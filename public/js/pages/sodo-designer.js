(function () {
    const SVG_NS = 'http://www.w3.org/2000/svg';

    const canvas = document.getElementById('gaCanvas');
    const objectsLayer = document.getElementById('gaObjectsLayer');
    const hiddenInput = document.getElementById('ga_so_do');
    const contextMenu = document.getElementById('gaContextMenu');
    const contextMenuDeleteBtn = document.getElementById('gaContextMenuDelete');

    if (!canvas || !objectsLayer || !hiddenInput) {
        return;
    }

    let state = { objects: [], arrows: [] };
    let contextMenuTargetId = null;

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
        switch (color) {
            case 'blue': return '#0ffdfd';
            case 'green': return '#0af15f';
            case 'yellow': return '#fffc32';
            case 'orange': return '#ffcf66';
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

    function baoDaThayDoi() {
        window.dispatchEvent(new CustomEvent('ga:sodo-changed'));
    }

    function moContextMenu(clientX, clientY, id) {
        contextMenuTargetId = id;
        contextMenu.style.left = clientX + 'px';
        contextMenu.style.top = clientY + 'px';
        contextMenu.style.display = 'block';
    }

    function dongContextMenu() {
        contextMenu.style.display = 'none';
        contextMenuTargetId = null;
    }

    document.addEventListener('click', function () {
        dongContextMenu();
    });

    contextMenuDeleteBtn.addEventListener('click', function () {
        if (contextMenuTargetId) {
            xoaVatDung(contextMenuTargetId);
        }
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
        const target = e.target.closest('.ga-object');
        if (target) {
            moContextMenu(e.clientX, e.clientY, target.dataset.id);
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
            }
        } catch (err) {
            state = { objects: [], arrows: [] };
        }
    }

    naploLaiDuLieuCu();
    dongBoHiddenInput();
})();