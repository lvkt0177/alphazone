(function () {
    const THANG_LABEL = 'Tháng';
    const THU_LABELS = ['H', 'B', 'T', 'N', 'S', 'B', 'C'];

    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function parseISO(value) {
        if (!value) return null;
        const parts = value.split('-');
        if (parts.length !== 3) return null;
        const d = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
        return isNaN(d.getTime()) ? null : d;
    }

    function toISO(date) {
        return date.getFullYear() + '-' + pad2(date.getMonth() + 1) + '-' + pad2(date.getDate());
    }

    function toDisplay(date) {
        return pad2(date.getDate()) + '/' + pad2(date.getMonth() + 1) + '/' + date.getFullYear();
    }

    function enhance(nativeInput) {
        if (nativeInput.dataset.dpEnhanced) return;
        nativeInput.dataset.dpEnhanced = '1';

        const minDate = parseISO(nativeInput.getAttribute('min'));
        const maxDate = parseISO(nativeInput.getAttribute('max'));

        let selected = parseISO(nativeInput.value);
        let view = selected ? new Date(selected.getFullYear(), selected.getMonth(), 1) : new Date();
        view.setDate(1);
        let open = false;

        const wrap = document.createElement('div');
        wrap.className = 'dp-wrap';

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'dp-trigger';
        if (nativeInput.disabled) trigger.disabled = true;

        const panel = document.createElement('div');
        panel.className = 'dp-panel';
        panel.style.display = 'none';

        nativeInput.parentNode.insertBefore(wrap, nativeInput);
        wrap.appendChild(nativeInput);
        wrap.appendChild(trigger);
        wrap.appendChild(panel);
        nativeInput.style.display = 'none';

        // renderPanel() xoá/tạo lại DOM bên trong panel ngay khi xử lý click (VD nút
        // tiến/lùi tháng) — nếu để sự kiện click nổi lên document, phần tử vừa bấm đã
        // bị gỡ khỏi DOM nên wrap.contains(e.target) trả về false, khiến panel bị tưởng
        // nhầm là "bấm ra ngoài" và tự đóng ngay sau khi vừa chuyển tháng. Chặn hẳn ở đây.
        panel.addEventListener('click', (e) => e.stopPropagation());

        // Một số trang set thẳng input.value bằng JS khi mở modal Sửa (VD: teachers.js,
        // students.js, trial.js, tuition.js) mà không bắn event input/change. Override lại
        // property 'value' để bất kỳ chỗ nào gán giá trị (kể cả code khác) cũng tự đồng bộ
        // lại phần hiển thị của lịch, tránh trigger bị đơ hiển thị sai ngày.
        const desc = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
        Object.defineProperty(nativeInput, 'value', {
            configurable: true,
            get() { return desc.get.call(nativeInput); },
            set(v) {
                desc.set.call(nativeInput, v);
                selected = parseISO(v);
                view = selected ? new Date(selected.getFullYear(), selected.getMonth(), 1) : new Date();
                view.setDate(1);
                renderTrigger();
                if (open) renderPanel();
            },
        });

        function isDisabledDay(date) {
            if (minDate && date < minDate) return true;
            if (maxDate && date > maxDate) return true;
            return false;
        }

        function renderTrigger() {
            trigger.textContent = selected ? toDisplay(selected) : (nativeInput.placeholder || 'Chọn ngày');
            trigger.classList.toggle('dp-trigger-empty', !selected);
        }

        function renderPanel() {
            panel.innerHTML = '';

            const head = document.createElement('div');
            head.className = 'dp-head';

            const prev = document.createElement('button');
            prev.type = 'button';
            prev.className = 'dp-nav';
            prev.innerHTML = '<i class="ri-arrow-left-s-line"></i>';
            prev.onclick = () => { view.setMonth(view.getMonth() - 1); renderPanel(); };

            const label = document.createElement('span');
            label.className = 'dp-label';
            label.textContent = THANG_LABEL + ' ' + (view.getMonth() + 1) + ' ' + view.getFullYear();

            const next = document.createElement('button');
            next.type = 'button';
            next.className = 'dp-nav';
            next.innerHTML = '<i class="ri-arrow-right-s-line"></i>';
            next.onclick = () => { view.setMonth(view.getMonth() + 1); renderPanel(); };

            head.append(prev, label, next);
            panel.appendChild(head);

            const grid = document.createElement('div');
            grid.className = 'dp-grid';

            THU_LABELS.forEach((t) => {
                const el = document.createElement('div');
                el.className = 'dp-thu';
                el.textContent = t;
                grid.appendChild(el);
            });

            const first = new Date(view.getFullYear(), view.getMonth(), 1);
            const offset = (first.getDay() + 6) % 7;
            const daysInMonth = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();

            for (let i = 0; i < offset; i++) grid.appendChild(document.createElement('div'));

            const today = new Date();
            for (let d = 1; d <= daysInMonth; d++) {
                const cellDate = new Date(view.getFullYear(), view.getMonth(), d);
                const cell = document.createElement('div');
                cell.textContent = d;
                cell.className = 'dp-cell';
                if (isDisabledDay(cellDate)) {
                    cell.classList.add('dp-cell-disabled');
                } else {
                    cell.onclick = () => {
                        nativeInput.value = toISO(cellDate);
                        nativeInput.dispatchEvent(new Event('input', { bubbles: true }));
                        nativeInput.dispatchEvent(new Event('change', { bubbles: true }));
                        closePanel();
                    };
                }
                if (
                    selected && cellDate.getFullYear() === selected.getFullYear()
                    && cellDate.getMonth() === selected.getMonth() && cellDate.getDate() === selected.getDate()
                ) {
                    cell.classList.add('dp-cell-selected');
                } else if (
                    cellDate.getFullYear() === today.getFullYear()
                    && cellDate.getMonth() === today.getMonth() && cellDate.getDate() === today.getDate()
                ) {
                    cell.classList.add('dp-cell-today');
                }
                grid.appendChild(cell);
            }

            panel.appendChild(grid);

            const foot = document.createElement('div');
            foot.className = 'dp-foot';

            const clear = document.createElement('button');
            clear.type = 'button';
            clear.className = 'dp-foot-btn dp-foot-clear';
            clear.textContent = 'Xoá';
            clear.onclick = () => {
                nativeInput.value = '';
                nativeInput.dispatchEvent(new Event('input', { bubbles: true }));
                nativeInput.dispatchEvent(new Event('change', { bubbles: true }));
                closePanel();
            };

            const todayBtn = document.createElement('button');
            todayBtn.type = 'button';
            todayBtn.className = 'dp-foot-btn dp-foot-today';
            todayBtn.textContent = 'Hôm nay';
            todayBtn.onclick = () => {
                if (isDisabledDay(today)) return;
                view = new Date(today.getFullYear(), today.getMonth(), 1);
                nativeInput.value = toISO(today);
                nativeInput.dispatchEvent(new Event('input', { bubbles: true }));
                nativeInput.dispatchEvent(new Event('change', { bubbles: true }));
                closePanel();
            };

            foot.append(clear, todayBtn);
            panel.appendChild(foot);
        }

        function openPanel() {
            if (nativeInput.disabled || open) return;
            view = selected ? new Date(selected.getFullYear(), selected.getMonth(), 1) : new Date();
            view.setDate(1);
            renderPanel();
            panel.style.display = 'block';
            open = true;
        }

        function closePanel() {
            panel.style.display = 'none';
            open = false;
        }

        trigger.addEventListener('click', () => { open ? closePanel() : openPanel(); });

        document.addEventListener('click', (e) => {
            if (open && !wrap.contains(e.target)) closePanel();
        });

        document.addEventListener('keydown', (e) => {
            if (open && e.key === 'Escape') closePanel();
        });

        renderTrigger();
    }

    function scan() {
        document.querySelectorAll('input[type="date"]').forEach(enhance);
    }

    document.addEventListener('DOMContentLoaded', scan);
    window.dpRescan = scan;
})();