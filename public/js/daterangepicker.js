(function () {
    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function toISO(date) {
        return date.getFullYear() + '-' + pad2(date.getMonth() + 1) + '-' + pad2(date.getDate());
    }

    function toDisplay(date) {
        return pad2(date.getDate()) + '/' + pad2(date.getMonth() + 1) + '/' + date.getFullYear();
    }

    function parseISO(value) {
        if (!value) return null;
        const parts = value.split('-');
        if (parts.length !== 3) return null;
        const d = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
        return isNaN(d.getTime()) ? null : d;
    }

    function sameDay(a, b) {
        return a && b && a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
    }

    function init(wrap) {
        if (wrap.dataset.drEnhanced) return;
        wrap.dataset.drEnhanced = '1';

        const inputTu = wrap.querySelector('[data-dr-start]');
        const inputDen = wrap.querySelector('[data-dr-end]');

        let start = parseISO(inputTu.value);
        let end = parseISO(inputDen.value);
        let hover = null;
        let base = start ? new Date(start.getFullYear(), start.getMonth(), 1) : new Date();
        base.setDate(1);
        let open = false;

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'dp-trigger';

        const panel = document.createElement('div');
        panel.className = 'dr-panel';
        panel.style.display = 'none';
        panel.addEventListener('click', (e) => e.stopPropagation());

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        function renderTrigger() {
            trigger.textContent = (start && end) ? (toDisplay(start) + ' - ' + toDisplay(end)) : 'Chọn khoảng ngày';
            trigger.classList.toggle('dp-trigger-empty', !(start && end));
        }

        function buildCalendar(offset) {
            const view = new Date(base.getFullYear(), base.getMonth() + offset, 1);
            const col = document.createElement('div');
            col.className = 'dr-cal';

            const label = document.createElement('div');
            label.className = 'dr-cal-label';
            label.textContent = 'Tháng ' + (view.getMonth() + 1) + ' ' + view.getFullYear();
            col.appendChild(label);

            const grid = document.createElement('div');
            grid.className = 'dp-grid';
            ['H', 'B', 'T', 'N', 'S', 'B', 'C'].forEach((t) => {
                const el = document.createElement('div');
                el.className = 'dp-thu';
                el.textContent = t;
                grid.appendChild(el);
            });

            const first = new Date(view.getFullYear(), view.getMonth(), 1);
            const offsetDay = (first.getDay() + 6) % 7;
            const daysInMonth = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();
            for (let i = 0; i < offsetDay; i++) grid.appendChild(document.createElement('div'));

            for (let d = 1; d <= daysInMonth; d++) {
                const cellDate = new Date(view.getFullYear(), view.getMonth(), d);
                const cell = document.createElement('div');
                cell.textContent = d;
                cell.className = 'dp-cell';

                const rangeEnd = end || hover;
                const inRange = start && rangeEnd && cellDate >= (start < rangeEnd ? start : rangeEnd) && cellDate <= (start < rangeEnd ? rangeEnd : start);
                if (inRange) cell.classList.add('dr-cell-inrange');
                if (sameDay(cellDate, start) || sameDay(cellDate, end)) cell.classList.add('dp-cell-selected');

                cell.onmouseenter = () => {
                    if (start && !end) { hover = cellDate; renderPanel(); }
                };
                cell.onclick = () => {
                    if (!start || end) {
                        start = cellDate;
                        end = null;
                        hover = null;
                    } else {
                        if (cellDate < start) {
                            end = start;
                            start = cellDate;
                        } else {
                            end = cellDate;
                        }
                        inputTu.value = toISO(start);
                        inputDen.value = toISO(end);
                        renderTrigger();
                        closePanel();
                        return;
                    }
                    renderPanel();
                };
                grid.appendChild(cell);
            }

            col.appendChild(grid);
            return col;
        }

        function renderPanel() {
            panel.innerHTML = '';

            const head = document.createElement('div');
            head.className = 'dr-head';

            const prev = document.createElement('button');
            prev.type = 'button';
            prev.className = 'dp-nav';
            prev.innerHTML = '<i class="ri-arrow-left-s-line"></i>';
            prev.onclick = () => { base.setMonth(base.getMonth() - 1); renderPanel(); };

            const next = document.createElement('button');
            next.type = 'button';
            next.className = 'dp-nav';
            next.innerHTML = '<i class="ri-arrow-right-s-line"></i>';
            next.onclick = () => { base.setMonth(base.getMonth() + 1); renderPanel(); };

            head.append(prev, next);
            panel.appendChild(head);

            const cals = document.createElement('div');
            cals.className = 'dr-cals';
            cals.append(buildCalendar(0), buildCalendar(1));
            panel.appendChild(cals);

            const foot = document.createElement('div');
            foot.className = 'dp-foot';
            const clear = document.createElement('button');
            clear.type = 'button';
            clear.className = 'dp-foot-btn dp-foot-clear';
            clear.textContent = 'Xoá';
            clear.onclick = () => {
                start = null;
                end = null;
                hover = null;
                inputTu.value = '';
                inputDen.value = '';
                renderTrigger();
                renderPanel();
            };
            const hint = document.createElement('span');
            hint.className = 'dr-hint';
            hint.textContent = start && !end ? 'Chọn ngày kết thúc' : 'Chọn ngày bắt đầu';
            foot.append(clear, hint);
            panel.appendChild(foot);
        }

        function openPanel() {
            if (open) return;
            base = start ? new Date(start.getFullYear(), start.getMonth(), 1) : new Date();
            base.setDate(1);
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
        document.querySelectorAll('[data-daterange]').forEach(init);
    }

    document.addEventListener('DOMContentLoaded', scan);
})();