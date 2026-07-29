(function () {
    const SVG_NS = 'http://www.w3.org/2000/svg';

    const canvas = document.getElementById('gaCanvas');
    const objectsLayer = document.getElementById('gaObjectsLayer');
    const arrowsLayer = document.getElementById('gaArrowsLayer');
    const hiddenInput = document.getElementById('ga_so_do');
    const contextMenu = document.getElementById('gaContextMenu');
    const contextMenuEditBtn = document.getElementById('gaContextMenuEdit');
    const contextMenuDeleteBtn = document.getElementById('gaContextMenuDelete');
    const toolButtons = document.querySelectorAll('.sodo-tool-btn');
    const gaSoInput = document.getElementById('gaSoInput');
    const gaSoSaveBtn = document.getElementById('gaSoSaveBtn');

    if (!canvas || !objectsLayer || !arrowsLayer || !hiddenInput) {
        return;
    }

    let state = { objects: [], arrows: [] };
    let contextMenuTargetId = null;
    let contextMenuTargetType = null;
    let congCuHienTai = 'select';
    let dangVe = false;
    let diemBatDau = null;
    let previewLine = null;
    let arrowDangSuaSo = null;
    let arrowDangChon = null;
    let dangKeoDiem = null;
    let dangKeoCaMuiTen = null;
    let dangKeoVatDung = null;

    function taoId() {
        return 'o' + Date.now().toString(36) + Math.random().toString(36).slice(2, 7);
    }

    function dongBoHiddenInput() {
        hiddenInput.value = JSON.stringify(state);
    }

    function toaDoTrongSvg(clientX, clientY) {
        const pt = canvas.createSVGPoint();
        pt.x = clientX;
        pt.y = clientY;
        const ctm = canvas.getScreenCTM();
        if (!ctm) return { x: 0, y: 0 };
        const local = pt.matrixTransform(ctm.inverse());
        return { x: local.x, y: local.y };
    }

    function noiDungHinh(type, color) {
        switch (type) {
            case 'nam':
                return '<circle r="16" fill="' + mauSac(color) + '"></circle>'
                    + '<circle r="5" fill="#111111"></circle>';
            case 'con':
                return '<svg x="-25" y="-25" width="50" height="50" viewBox="0 0 16 16">'
                    + '<path fill="' + mauSac(color) + '" d="M7.03 1.88c.252-1.01 1.688-1.01 1.94 0l2.905 11.62H14a.5.5 0 0 1 0 1H2a.5.5 0 0 1 0-1h2.125z"></path>'
                    + '</svg>';
            case 'bong':
                return '<svg x="-16" y="-16" width="32" height="32" viewBox="0 0 64 64">'
                    + '<circle cx="32" cy="32" r="29.3" fill="#ffffff"></circle>'
                    + '<path fill="#4a4e51" d="M61.9 32c0-.7.2-10.9-5.8-17.5c-.3-.6-1.5-3-5.6-5.9C47.8 6.5 45 5 44.7 4.8S39.4 2 33.4 2c-.5 0-.9 0-1.4.1c-4.6-.1-8.8 1.1-11.9 2.5c-3.2 1.4-5.3 2.8-5.5 3c-3.4 1.9-9.9 9.5-10.4 13.6c-2.1 2.6-3.8 14.5 0 21.7c2.7 10 12.7 15 13.5 15.4c.5.3 5.9 3.7 12.6 3.7h.9c.6.1 1.1.1 1.7.1c7.2 0 18-5.1 20.2-9.1c6.2-4.6 9.4-16.2 8.8-21M17.8 47.1c-2.9-4.6-4.5-10.7-4.9-12.1c.9-1.4 5.4-8 7.9-10c1.4.3 7.5 1.4 13.2 2.4c.7 1.9 3.9 10 4.8 13.2c-1 1.2-4.9 5.7-8.7 9.2c-4.1.1-11-2.3-12.3-2.7m36-32.5c0 .4-.1 2-.9 3.9c-1.5-.8-5.3-2.4-10.6-2.7c-.8-1.2-3.8-5.3-8.5-8.1c.6-1.3 1.5-2.8 2.1-3.3c.2 0 .4-.1.8-.1c2.5 0 6.9 1.7 7.3 1.8c.4.2 8.3 4.4 9.8 8.5M11.8 34c-3.4-.6-5.5-1.6-6.1-2c-1.3-4.6-.2-9.6-.1-10.3c1.3-2.2 4.8-8 7.2-9.1c2.4-.5 5.5.1 6.7.4c-.1 1.6-.3 6.1.3 10.9c-2.6 2.2-6.9 8.5-8 10.1M31.7 3.5c.8.1 1.9.2 2.7.5c-.8 1-1.6 2.5-1.9 3.3c-1.6.3-7.5 1.4-12.2 4.4c-.9-.2-3.8-.9-6.5-.7c.7-1.3 1.7-2.2 1.8-2.3c.3-.3 7.4-5.3 16.1-5.2m19.1 38.1c-1.2 0-5.7-.3-10.6-1.5c-.9-3.3-4.1-11.4-4.8-13.3c3.1-4.4 6.1-8.5 6.9-9.7c5.7.4 9.7 2.5 10.5 2.9c3.3 5.3 4 10.7 4.1 11.6c-1.8 5.5-5.2 9.2-6.1 10M3.7 28.5c.1 1.3.3 2.6.7 3.9c-.3.9-.6 1.8-.7 2.7c-.3-2.3-.3-4.6 0-6.6M18.5 57l-.4.6zc-2.5-1.2-4.4-4-5.2-5.1c1.5-1.5 3.4-2.9 4.1-3.4c1.6.6 8.3 2.8 12.6 2.8c.7 1 3.1 4 6 6.4c-1.8 1.8-4.4 2.6-4.9 2.8c-6.8.2-12.6-3.5-12.6-3.5m16.3 3.4c.9-.5 1.9-1.2 2.7-2.1c1.3-.2 6.9-1.1 11.9-4.8c.3 0 .9.1 1.5.1c-3.1 2.9-10.5 6.2-16.1 6.8M50.2 52c1.8-4.7 1.7-8.3 1.6-9.4c1-1 4.4-4.6 6.3-10.1c1 .2 1.7.4 2 .6c.1.4.3 1.3.2 2.7c-.8 5-3.4 12.6-8.1 15.9c-.5.3-1.3.4-2 .3"></path>'
                    + '</svg>';
            case 'nguoi':
                return '<svg x="-30" y="-30" width="60" height="60" viewBox="0 0 24 24">'
                    + '<path fill="' + mauSac(color) + '" d="M12 2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m-1.5 5h3a2 2 0 0 1 2 2v5.5H14V22h-4v-7.5H8.5V9a2 2 0 0 1 2-2"></path>'
                    + '</svg>';
            case 'giaovien':
                return '<circle r="16" fill="#111111"></circle>'
                    + '<text y="6" font-size="16" fill="#ffffff" text-anchor="middle">C</text>';
            case 'hotro':
                return '<circle r="16" fill="#111111"></circle>'
                    + '<text y="6" font-size="16" fill="#ffffff" text-anchor="middle">A</text>';
            default:
                return '';
        }
    }

    function mauSac(color) {
        const bang = window.__gaMauSac || {};
        switch (color) {
            case 'blue': return bang.blue || '#0ffdfd';
            case 'green': return bang.green || '#0af15f';
            case 'yellow': return bang.yellow || '#fffc32';
            case 'orange': return bang.orange || '#ffcf66';
            default: return '#111111';
        }
    }

    function renderObject(obj) {
        const g = document.createElementNS(SVG_NS, 'g');
        g.setAttribute('class', 'ga-object');
        g.setAttribute('transform', 'translate(' + obj.x + ',' + obj.y + ')');
        g.dataset.id = obj.id;
        g.innerHTML = noiDungHinh(obj.type, obj.color);

        objectsLayer.appendChild(g);
    }

    function themVatDung(type, color, x, y) {
        const obj = { id: taoId(), type: type, color: color || undefined, x: Math.round(x), y: Math.round(y) };
        state.objects.push(obj);
        renderObject(obj);
        dongBoHiddenInput();
        baoDaThayDoi();
    }

    function xoaVatDung(id) {
        state.objects = state.objects.filter(function (o) { return o.id !== id; });
        const node = objectsLayer.querySelector('[data-id="' + id + '"]');
        if (node) node.remove();
        dongBoHiddenInput();
        baoDaThayDoi();
    }

    function renderArrow(arrow) {
        const g = document.createElementNS(SVG_NS, 'g');
        g.setAttribute('class', 'ga-arrow');
        g.dataset.id = arrow.id;

        if (arrow.type === 'dan_bong') {
            renderMuiTenDanBong(g, arrow);
        } else {
            renderMuiTenThang(g, arrow);
        }

        arrowsLayer.appendChild(g);
    }

    function veLaiMuiTen(id) {
        const arrow = state.arrows.find(function (a) { return a.id === id; });
        if (!arrow) return;
        const node = arrowsLayer.querySelector('[data-id="' + id + '"]');
        if (node) node.remove();
        renderArrow(arrow);
    }

    function renderMuiTenThang(g, arrow) {
        const p1 = arrow.points[0];
        const p2 = arrow.points[arrow.points.length - 1];
        const midX = (p1[0] + p2[0]) / 2;
        const midY = (p1[1] + p2[1]) / 2;

        const dx = p2[0] - p1[0];
        const dy = p2[1] - p1[1];
        const len = Math.sqrt(dx * dx + dy * dy) || 1;
        const ux = dx / len;
        const uy = dy / len;
        const px = -uy;
        const py = ux;

        // Đầu mũi tên: vẽ tam giác riêng, căn đúng theo hướng đường vẽ (không dùng SVG marker vì dễ bị lệch/méo)
        const dai = 35;
        const rong = 15;
        const dinh = [p2[0], p2[1]];
        const goc1 = [p2[0] - ux * dai + px * rong, p2[1] - uy * dai + py * rong];
        const goc2 = [p2[0] - ux * dai - px * rong, p2[1] - uy * dai - py * rong];
        const cuoiThan = [p2[0] - ux * dai, p2[1] - uy * dai];

        const dauMuiTen = '<polygon points="' + dinh[0] + ',' + dinh[1] + ' ' + goc1[0] + ',' + goc1[1] + ' ' + goc2[0] + ',' + goc2[1] + '" fill="#000000"></polygon>';

        let thanMarkup = '';
        if (arrow.type === 'sut') {
            const ox = px * 4;
            const oy = py * 4;
            thanMarkup = '<line x1="' + (p1[0] + ox) + '" y1="' + (p1[1] + oy) + '" x2="' + (cuoiThan[0] + ox) + '" y2="' + (cuoiThan[1] + oy) + '" stroke="#000000" stroke-width="3"></line>'
                + '<line x1="' + (p1[0] - ox) + '" y1="' + (p1[1] - oy) + '" x2="' + (cuoiThan[0] - ox) + '" y2="' + (cuoiThan[1] - oy) + '" stroke="#000000" stroke-width="3"></line>';
        } else {
            thanMarkup = '<line x1="' + p1[0] + '" y1="' + p1[1] + '" x2="' + cuoiThan[0] + '" y2="' + cuoiThan[1] + '" stroke="#000000" stroke-width="3"></line>';
        }

        const nhanSo = '<circle cx="' + midX + '" cy="' + midY + '" r="11" fill="#ffffff" stroke="#000000" stroke-width="1.5" class="ga-arrow-so-bg"></circle>'
            + '<text x="' + midX + '" y="' + (midY + 4) + '" font-size="12" font-weight="700" fill="#000000" text-anchor="middle" class="ga-arrow-so-text">' + arrow.so + '</text>';

        // Vùng bấm vô hình, dày hơn nhiều so với nét vẽ thật, để bấm/kéo dễ trúng hơn
        const vungBam = '<line x1="' + p1[0] + '" y1="' + p1[1] + '" x2="' + cuoiThan[0] + '" y2="' + cuoiThan[1] + '" stroke="#000000" stroke-opacity="0" stroke-width="24" pointer-events="stroke"></line>';

        g.innerHTML = vungBam + thanMarkup + dauMuiTen + nhanSo;
    }

    function duongCongCatmullRom(diem) {
        if (diem.length < 2) return '';
        let d = 'M ' + diem[0][0] + ' ' + diem[0][1] + ' ';
        for (let i = 0; i < diem.length - 1; i++) {
            const p0 = diem[i - 1] || diem[i];
            const p1 = diem[i];
            const p2 = diem[i + 1];
            const p3 = diem[i + 2] || p2;
            const cp1x = p1[0] + (p2[0] - p0[0]) / 6;
            const cp1y = p1[1] + (p2[1] - p0[1]) / 6;
            const cp2x = p2[0] - (p3[0] - p1[0]) / 6;
            const cp2y = p2[1] - (p3[1] - p1[1]) / 6;
            d += 'C ' + cp1x + ' ' + cp1y + ' ' + cp2x + ' ' + cp2y + ' ' + p2[0] + ' ' + p2[1] + ' ';
        }
        return d;
    }

    function renderMuiTenDanBong(g, arrow) {
        g.classList.add('ga-arrow--dan-bong');
        const diem = arrow.points;
        const duongCong = duongCongCatmullRom(diem);

        const pTruocCuoi = diem[diem.length - 2];
        const pCuoi = diem[diem.length - 1];
        const dx = pCuoi[0] - pTruocCuoi[0];
        const dy = pCuoi[1] - pTruocCuoi[1];
        const len = Math.sqrt(dx * dx + dy * dy) || 1;
        const ux = dx / len;
        const uy = dy / len;
        const px = -uy;
        const py = ux;

        const dai = 35;
        const rong = 15;
        const goc1 = [pCuoi[0] - ux * dai + px * rong, pCuoi[1] - uy * dai + py * rong];
        const goc2 = [pCuoi[0] - ux * dai - px * rong, pCuoi[1] - uy * dai - py * rong];
        const dauMuiTen = '<polygon points="' + pCuoi[0] + ',' + pCuoi[1] + ' ' + goc1[0] + ',' + goc1[1] + ' ' + goc2[0] + ',' + goc2[1] + '" fill="#000000"></polygon>';

        const duongMarkup = '<path d="' + duongCong + '" fill="none" stroke="#000000" stroke-width="3" stroke-dasharray="10,7" stroke-linecap="round"></path>';

        const diemGiua = diem[Math.floor(diem.length / 2)];
        const nhanSo = '<circle cx="' + diemGiua[0] + '" cy="' + diemGiua[1] + '" r="11" fill="#ffffff" stroke="#000000" stroke-width="1.5" class="ga-arrow-so-bg"></circle>'
            + '<text x="' + diemGiua[0] + '" y="' + (diemGiua[1] + 4) + '" font-size="12" font-weight="700" fill="#000000" text-anchor="middle" class="ga-arrow-so-text">' + arrow.so + '</text>';

        let taySamMarkup = '';
        if (arrow.id === arrowDangChon) {
            taySamMarkup = diem.map(function (p, idx) {
                return '<circle class="ga-arrow-handle" data-index="' + idx + '" cx="' + p[0] + '" cy="' + p[1] + '" r="7" fill="#2563EB" stroke="#ffffff" stroke-width="2"></circle>';
            }).join('');
        }

        // Vùng bấm vô hình, dày và liền mạch (không đứt đoạn như nét vẽ thật) để bấm/kéo dễ trúng hơn
        const vungBam = '<path d="' + duongCong + '" fill="none" stroke="#000000" stroke-opacity="0" stroke-width="28" pointer-events="stroke"></path>';

        g.innerHTML = vungBam + duongMarkup + dauMuiTen + nhanSo + taySamMarkup;
    }

    function laySoLonNhatHienTai() {
        return state.arrows.reduce(function (max, a) {
            return Math.max(max, Number(a.so) || 0);
        }, 0);
    }

    function themMuiTen(type, p1, p2) {
        let points;
        if (type === 'dan_bong') {
            points = [];
            for (let i = 0; i <= 4; i++) {
                const t = i / 4;
                points.push([
                    Math.round(p1.x + (p2.x - p1.x) * t),
                    Math.round(p1.y + (p2.y - p1.y) * t),
                ]);
            }
        } else {
            points = [[Math.round(p1.x), Math.round(p1.y)], [Math.round(p2.x), Math.round(p2.y)]];
        }

        const arrow = {
            id: taoId(),
            type: type,
            so: laySoLonNhatHienTai() + 1,
            points: points,
        };
        state.arrows.push(arrow);
        renderArrow(arrow);
        dongBoHiddenInput();
        baoDaThayDoi();
    }

    function xoaMuiTen(id) {
        state.arrows = state.arrows.filter(function (a) { return a.id !== id; });
        const node = arrowsLayer.querySelector('[data-id="' + id + '"]');
        if (node) node.remove();
        if (arrowDangChon === id) arrowDangChon = null;
        dongBoHiddenInput();
        baoDaThayDoi();
    }

    function baoDaThayDoi() {
        window.dispatchEvent(new CustomEvent('ga:sodo-changed'));
    }

    function moContextMenu(clientX, clientY, id, type) {
        contextMenuTargetId = id;
        contextMenuTargetType = type;
        contextMenuEditBtn.style.display = type === 'arrow' ? 'flex' : 'none';
        contextMenu.style.left = clientX + 'px';
        contextMenu.style.top = clientY + 'px';
        contextMenu.style.display = 'block';
    }

    function dongContextMenu() {
        contextMenu.style.display = 'none';
        contextMenuTargetId = null;
        contextMenuTargetType = null;
    }

    document.addEventListener('click', function () {
        dongContextMenu();
    });

    contextMenuDeleteBtn.addEventListener('click', function () {
        if (contextMenuTargetId) {
            if (contextMenuTargetType === 'arrow') {
                xoaMuiTen(contextMenuTargetId);
            } else {
                xoaVatDung(contextMenuTargetId);
            }
        }
        dongContextMenu();
    });

    function moModalSuaSo(arrow) {
        arrowDangSuaSo = arrow;
        gaSoInput.value = arrow.so;
        openModal('gaSoModal');
    }

    contextMenuEditBtn.addEventListener('click', function () {
        if (contextMenuTargetType !== 'arrow' || !contextMenuTargetId) return;
        const arrow = state.arrows.find(function (a) { return a.id === contextMenuTargetId; });
        if (arrow) moModalSuaSo(arrow);
        dongContextMenu();
    });

    document.querySelectorAll('.sodo-palette-item').forEach(function (item) {
        item.addEventListener('dragstart', function (e) {
            e.dataTransfer.setData('application/json', JSON.stringify({
                type: item.dataset.type,
                color: item.dataset.color || '',
            }));
        });
    });

    canvas.addEventListener('dragover', function (e) {
        e.preventDefault();
    });

    canvas.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        const targetObj = e.target.closest('.ga-object');
        const targetArrow = e.target.closest('.ga-arrow');
        if (targetObj) {
            moContextMenu(e.clientX, e.clientY, targetObj.dataset.id, 'object');
        } else if (targetArrow) {
            moContextMenu(e.clientX, e.clientY, targetArrow.dataset.id, 'arrow');
        }
    });

    canvas.addEventListener('drop', function (e) {
        e.preventDefault();
        const raw = e.dataTransfer.getData('application/json');
        if (!raw) return;
        const data = JSON.parse(raw);
        const p = toaDoTrongSvg(e.clientX, e.clientY);
        themVatDung(data.type, data.color, p.x, p.y);
    });

    function chonCongCu(ten) {
        congCuHienTai = ten;
        toolButtons.forEach(function (b) {
            b.classList.toggle('active', b.dataset.tool === ten);
        });
        canvas.classList.toggle('sodo-canvas--drawing', ten !== 'select');
    }

    toolButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            chonCongCu(btn.dataset.tool);
        });
    });

    canvas.addEventListener('pointerdown', function (e) {
        if (e.button !== 0) return;
        if (congCuHienTai !== 'chuyen' && congCuHienTai !== 'sut' && congCuHienTai !== 'dan_bong') return;
        dangVe = true;
        diemBatDau = toaDoTrongSvg(e.clientX, e.clientY);

        previewLine = document.createElementNS(SVG_NS, 'line');
        previewLine.setAttribute('stroke', '#000000');
        previewLine.setAttribute('stroke-width', '2');
        previewLine.setAttribute('stroke-dasharray', '6,4');
        previewLine.setAttribute('x1', diemBatDau.x);
        previewLine.setAttribute('y1', diemBatDau.y);
        previewLine.setAttribute('x2', diemBatDau.x);
        previewLine.setAttribute('y2', diemBatDau.y);
        arrowsLayer.appendChild(previewLine);
    });

    canvas.addEventListener('pointermove', function (e) {
        if (!dangVe || !previewLine) return;
        const p = toaDoTrongSvg(e.clientX, e.clientY);
        previewLine.setAttribute('x2', p.x);
        previewLine.setAttribute('y2', p.y);
    });

    canvas.addEventListener('pointerup', function (e) {
        if (!dangVe) return;
        dangVe = false;

        const diemKetThuc = toaDoTrongSvg(e.clientX, e.clientY);
        if (previewLine) {
            previewLine.remove();
            previewLine = null;
        }

        const khoangCach = Math.hypot(diemKetThuc.x - diemBatDau.x, diemKetThuc.y - diemBatDau.y);
        if (khoangCach > 5) {
            themMuiTen(congCuHienTai, diemBatDau, diemKetThuc);
        }
        chonCongCu('select');
    });

    function chonMuiTenDanBong(id) {
        const idCu = arrowDangChon;
        if (idCu === id) return;
        arrowDangChon = id;
        if (idCu) veLaiMuiTen(idCu);
        if (id) veLaiMuiTen(id);
    }

    arrowsLayer.addEventListener('pointerdown', function (e) {
        if (e.button !== 0) return;
        const handle = e.target.closest('.ga-arrow-handle');
        if (handle) {
            e.stopPropagation();
            const parentG = handle.closest('.ga-arrow');
            if (!parentG) return;
            dangKeoDiem = { arrowId: parentG.dataset.id, index: parseInt(handle.dataset.index, 10) };
            return;
        }

        if (congCuHienTai !== 'select') return;
        const g = e.target.closest('.ga-arrow');
        if (!g) return;
        e.stopPropagation();
        const arrow = state.arrows.find(function (a) { return a.id === g.dataset.id; });
        if (!arrow) return;

        dangKeoCaMuiTen = {
            id: arrow.id,
            diemBatDauKeo: toaDoTrongSvg(e.clientX, e.clientY),
            diemGoc: arrow.points.map(function (p) { return [p[0], p[1]]; }),
        };
    });

    objectsLayer.addEventListener('pointerdown', function (e) {
        if (e.button !== 0) return;
        if (congCuHienTai !== 'select') return;
        const g = e.target.closest('.ga-object');
        if (!g) return;
        e.stopPropagation();
        const obj = state.objects.find(function (o) { return o.id === g.dataset.id; });
        if (!obj) return;

        dangKeoVatDung = {
            id: obj.id,
            diemBatDauKeo: toaDoTrongSvg(e.clientX, e.clientY),
            viTriGoc: { x: obj.x, y: obj.y },
        };
    });

    document.addEventListener('pointermove', function (e) {
        if (dangKeoDiem) {
            const p = toaDoTrongSvg(e.clientX, e.clientY);
            const arrow = state.arrows.find(function (a) { return a.id === dangKeoDiem.arrowId; });
            if (arrow) {
                arrow.points[dangKeoDiem.index] = [Math.round(p.x), Math.round(p.y)];
                veLaiMuiTen(arrow.id);
            }
            return;
        }

        if (dangKeoCaMuiTen) {
            const p = toaDoTrongSvg(e.clientX, e.clientY);
            const dx = p.x - dangKeoCaMuiTen.diemBatDauKeo.x;
            const dy = p.y - dangKeoCaMuiTen.diemBatDauKeo.y;
            const arrow = state.arrows.find(function (a) { return a.id === dangKeoCaMuiTen.id; });
            if (arrow) {
                arrow.points = dangKeoCaMuiTen.diemGoc.map(function (p0) {
                    return [Math.round(p0[0] + dx), Math.round(p0[1] + dy)];
                });
                veLaiMuiTen(arrow.id);
            }
            return;
        }

        if (dangKeoVatDung) {
            const p = toaDoTrongSvg(e.clientX, e.clientY);
            const dx = p.x - dangKeoVatDung.diemBatDauKeo.x;
            const dy = p.y - dangKeoVatDung.diemBatDauKeo.y;
            const obj = state.objects.find(function (o) { return o.id === dangKeoVatDung.id; });
            if (obj) {
                obj.x = Math.round(dangKeoVatDung.viTriGoc.x + dx);
                obj.y = Math.round(dangKeoVatDung.viTriGoc.y + dy);
                const g = objectsLayer.querySelector('[data-id="' + obj.id + '"]');
                if (g) g.setAttribute('transform', 'translate(' + obj.x + ',' + obj.y + ')');
            }
        }
    });

    document.addEventListener('pointerup', function () {
        if (dangKeoDiem) {
            dangKeoDiem = null;
            dongBoHiddenInput();
            baoDaThayDoi();
            return;
        }

        if (dangKeoCaMuiTen) {
            dangKeoCaMuiTen = null;
            dongBoHiddenInput();
            baoDaThayDoi();
            return;
        }

        if (dangKeoVatDung) {
            dangKeoVatDung = null;
            dongBoHiddenInput();
            baoDaThayDoi();
        }
    });

    arrowsLayer.addEventListener('click', function (e) {
        if (congCuHienTai !== 'select') return;
        if (e.target.closest('.ga-arrow-handle')) return;

        const g = e.target.closest('.ga-arrow');
        if (!g) return;
        const arrow = state.arrows.find(function (a) { return a.id === g.dataset.id; });
        if (arrow && arrow.type === 'dan_bong') {
            chonMuiTenDanBong(arrow.id);
        }
    });

    canvas.addEventListener('click', function (e) {
        if (congCuHienTai !== 'select') return;
        if (e.target.closest('.ga-arrow') || e.target.closest('.ga-object')) return;
        chonMuiTenDanBong(null);
    });

    arrowsLayer.addEventListener('dblclick', function (e) {
        const g = e.target.closest('.ga-arrow');
        if (!g) return;
        const arrow = state.arrows.find(function (a) { return a.id === g.dataset.id; });
        if (!arrow) return;

        moModalSuaSo(arrow);
    });

    gaSoSaveBtn.addEventListener('click', function () {
        if (!arrowDangSuaSo) return;
        const soMoi = parseInt(gaSoInput.value, 10);
        if (isNaN(soMoi)) return;

        arrowDangSuaSo.so = soMoi;
        const g = arrowsLayer.querySelector('[data-id="' + arrowDangSuaSo.id + '"]');
        if (g) {
            const textEl = g.querySelector('.ga-arrow-so-text');
            if (textEl) textEl.textContent = soMoi;
        }
        dongBoHiddenInput();
        baoDaThayDoi();
        closeModal('gaSoModal');
        arrowDangSuaSo = null;
    });

    function naploLaiDuLieuCu() {
        if (!hiddenInput.value) return;
        try {
            const parsed = JSON.parse(hiddenInput.value);
            if (parsed && Array.isArray(parsed.objects)) {
                state.objects = parsed.objects;
                state.objects.forEach(renderObject);
            }
            if (parsed && Array.isArray(parsed.arrows)) {
                state.arrows = parsed.arrows;
                state.arrows.forEach(renderArrow);
            }
        } catch (err) {
            state = { objects: [], arrows: [] };
        }
    }

    // Giai đoạn 6: Cài đặt 4 màu vật dụng — lưu qua AJAX, KHÔNG load lại trang
    // (tránh mất sơ đồ đang vẽ dở nếu đang ở trang Tạo mới chưa lưu).
    const gaMauSacSaveBtn = document.getElementById('gaMauSacSaveBtn');
    const gaMauBlue = document.getElementById('gaMauBlue');
    const gaMauGreen = document.getElementById('gaMauGreen');
    const gaMauYellow = document.getElementById('gaMauYellow');
    const gaMauOrange = document.getElementById('gaMauOrange');

    function capNhatMauPalette(mau) {
        document.querySelectorAll('.sodo-palette-item').forEach(function (item) {
            const type = item.dataset.type;
            const mauKey = item.dataset.color;
            if (!mauKey || !mau[mauKey]) return;
            const svgEl = item.querySelector('svg');
            if (!svgEl) return;

            if (type === 'nam') {
                const vong = svgEl.querySelector('circle');
                if (vong) vong.setAttribute('fill', mau[mauKey]);
            } else if (type === 'con' || type === 'nguoi') {
                svgEl.style.color = mau[mauKey];
            }
        });
    }

    function veLaiTatCaSauKhiDoiMau() {
        state.objects.forEach(function (obj) {
            const g = objectsLayer.querySelector('[data-id="' + obj.id + '"]');
            if (g) g.remove();
            renderObject(obj);
        });
        state.arrows.forEach(function (arrow) {
            veLaiMuiTen(arrow.id);
        });
    }

    if (gaMauSacSaveBtn) {
        gaMauSacSaveBtn.addEventListener('click', function () {
            const duLieu = {
                blue: gaMauBlue.value,
                green: gaMauGreen.value,
                yellow: gaMauYellow.value,
                orange: gaMauOrange.value,
            };

            fetch(window.__gaMauSacUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.__gaCsrfToken || '',
                },
                body: JSON.stringify(duLieu),
            })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (!json || !json.success) return;
                    window.__gaMauSac = json.mau_sac;
                    capNhatMauPalette(json.mau_sac);
                    veLaiTatCaSauKhiDoiMau();
                    closeModal('gaMauSacModal');
                })
                .catch(function () {
                    // 
                });
        });
    }

    naploLaiDuLieuCu();
    dongBoHiddenInput();
})();