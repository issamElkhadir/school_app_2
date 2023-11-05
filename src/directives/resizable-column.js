let resizeContainer = null;

let table;

let handleResize;

const apply = (el) => {
    const nodeName = el.nodeName;

    if (['TABLE', 'THEAD'].indexOf(nodeName) < 0) return;

    table = nodeName === 'TABLE' ? el : el.parentElement;
    const thead = table.querySelector('thead');
    const ths = thead.querySelectorAll('th');
    const barHeight = nodeName === 'TABLE' ? table.offsetHeight : thead.offsetHeight;

    if (resizeContainer) {
        resizeContainer.remove();
    }

    resizeContainer = document.createElement('div');
    table.style.position = 'relative';
    resizeContainer.style.position = 'fixed';
    resizeContainer.style.zIndex = '5';
    resizeContainer.style.width = table.offsetWidth + 'px';
    resizeContainer.className = "vue-columns-resizable";
    table.parentElement.insertBefore(resizeContainer, table);

    let moving = false;
    let movingIndex = 0;

    table.parentElement.addEventListener("scroll", function () {
        resizeContainer.style.transform = `translateX(${-this.scrollLeft}px)`;
    });

    ths.forEach((th, index) => {
        th.style.width = th.offsetWidth + 'px';

        if (index + 1 >= ths.length) return;

        const nextTh = ths[index + 1];
        const bar = document.createElement('div');

        bar.style.position = 'absolute';
        bar.style.left = nextTh.offsetLeft - 4 + 'px';
        bar.style.top = '0';
        bar.style.height = barHeight + 'px';
        bar.style.width = '8px';
        bar.style.cursor = 'col-resize';
        bar.style.zIndex = '10';
        bar.className = 'columns-resize-bar';
        
        bar.addEventListener('mousedown', () => {
            moving = true;
            movingIndex = index;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
        });

        resizeContainer.appendChild(bar);
    });

    const bars = resizeContainer.querySelectorAll('.columns-resize-bar');

    document.addEventListener('mouseup', () => {
        if (!moving) return;

        moving = false;
        document.body.style.cursor = '';
        document.body.style.userSelect = '';

        bars.forEach((bar, index) => {
            const th = ths[index];
            const nextTh = ths[index + 1];
            th.style.width = th.offsetWidth + 'px';
            bar.style.left = nextTh.offsetLeft - 4 + 'px';
        });
    });

    const cutPx = str => +str.replace('px', '');

    handleResize = e => {
        if (moving) {
            const th = ths[movingIndex];
            const nextTh = ths[movingIndex + 1];
            const bar = bars[movingIndex];
            th.style.width = cutPx(th.style.width) + e.movementX + 'px';
            nextTh.style.width = cutPx(nextTh.style.width) - e.movementX + 'px';
            bar.style.left = nextTh.offsetLeft - 4 + e.movementX + 'px';
        }
    };

    resizeContainer.addEventListener('mousemove', handleResize);
    table.addEventListener('mousemove', handleResize);
}

export default {
    mounted: (el) => {
        apply(el);
        window.addEventListener("resize", () => apply(el));
    },

    updated: (el) => {
        apply(el);
        window.addEventListener("resize", () => apply(el));
    },

    beforeUnmount: (el) => {
        resizeContainer.addEventListener('mousemove', handleResize);
        table.addEventListener('mousemove', handleResize);
        window.removeEventListener("resize", () => apply(el));
    }
}