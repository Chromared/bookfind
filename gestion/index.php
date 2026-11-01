<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php
require '../actions/database.php';
require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFind — Management</title>
    <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
    <?php include 'includes/navbar.php'; ?>

    <main class="page">
      <div class="container container--wide">
        <div class="page-head">
          <div>
            <h1 class="page-head__title">Library management<?php if ($_SESSION['grade'] == '1') { ?> and BookFind<?php } ?></h1>
            <p class="page-head__sub">Overview of library activity.</p>
          </div>
        </div>

        <div class="grid grid--auto">

            <!-- Users -->
            <div class="card stat stat--primary">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-people"/></svg></div>
                    <div id="total-users" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Registered users</div>
            </div>

            <!-- Books -->
            <div class="card stat stat--success">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-book"/></svg></div>
                    <div id="total-books" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Registered books</div>
            </div>

            <!-- Available books -->
            <div class="card stat stat--info">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-check"/></svg></div>
                    <div id="available-books" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Available books</div>
            </div>

            <!-- Ongoing loans -->
            <div class="card stat stat--warning">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-arrow-up"/></svg></div>
                    <div id="loans" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Ongoing loans</div>
            </div>

            <!-- Late loans -->
            <div class="card stat stat--danger">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-alert"/></svg></div>
                    <div id="overdue_loans" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Overdue loans</div>
            </div>

            <!-- Returned loans -->
            <div class="card stat stat--info">
                <div class="card__body">
                    <div class="stat__icon"><svg class="icon"><use href="#i-arrow-down"/></svg></div>
                    <div id="returned_loans" class="stat__value">
                        <span class="spinner" role="status" aria-label="Loading..."></span>
                    </div>
                </div>
                <div class="card__footer">Returned loans</div>
            </div>

            <!-- Logs (admin only) -->
            <?php if ($_SESSION['grade'] == 1) { ?>
                <div class="card stat stat--secondary">
                    <div class="card__body">
                        <div class="stat__icon"><svg class="icon"><use href="#i-doc"/></svg></div>
                        <div id="log" class="stat__value">
                            <span class="spinner" role="status" aria-label="Loading..."></span>
                        </div>
                    </div>
                    <div class="card__footer">Logs</div>
                </div>
            <?php } ?>

        </div>

        <div class="charts-grid">

            <!-- Monthly loans -->
            <div class="card chart">
                <div class="card__header">
                    <svg class="icon"><use href="#i-arrow-up"/></svg>
                    <span>Loans over the last 6 months</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-monthly">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

            <!-- Loan status (pie) -->
            <div class="card chart chart--center">
                <div class="card__header">
                    <svg class="icon"><use href="#i-info"/></svg>
                    <span>Loan distribution by status</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-status" class="chart-split">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

            <!-- Top borrowers (horizontal bars) -->
            <div class="card chart">
                <div class="card__header">
                    <svg class="icon"><use href="#i-people"/></svg>
                    <span>Top borrowers</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-borrowers">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

            <!-- 12-month evolution (line) -->
            <div class="card chart">
                <div class="card__header">
                    <svg class="icon"><use href="#i-arrow-up"/></svg>
                    <span>Loan evolution — 12 months</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-evolution">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

            <!-- Users per class (donut) -->
            <div class="card chart">
                <div class="card__header">
                    <svg class="icon"><use href="#i-grid"/></svg>
                    <span>User distribution by class</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-users-classes" class="donut-wrap">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

            <!-- Books on loan (gauge) -->
            <div class="card chart">
                <div class="card__header">
                    <svg class="icon"><use href="#i-book"/></svg>
                    <span>Books currently on loan</span>
                </div>
                <div class="card__body chart__body">
                    <div id="chart-occupation">
                        <div class="center"><span class="spinner" role="status" aria-label="Loading..."></span></div>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </main>

    <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>" defer>
        function updateCounters() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'actions/others/count_data.php', true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById('total-users').textContent = data.total_users;
                    document.getElementById('total-books').textContent = data.total_books;
                    document.getElementById('available-books').textContent = data.total_available_books;
                    document.getElementById('loans').textContent = data.total_loans;
                    document.getElementById('overdue_loans').textContent = data.total_overdue_loans;
                    document.getElementById('returned_loans').textContent = data.total_returned_loans;
                    <?php if ($_SESSION['grade'] == 1) { ?>document.getElementById('log').textContent = data.total_logs;
                <?php } ?>
                } else {
                    console.error('Error in AJAX response');
                }
            };
            xhr.onerror = function() {
                console.error('AJAX network error');
            };
            xhr.send();
        }

        // --- Charts (rendered in pure CSS, no external dependency) ---
        var PALETTE = ['#5e6ad2', '#4ac46a', '#eab308', '#f2555a', '#38bdf8', '#a78bfa', '#f472b6', '#34d399', '#f97316', '#14b8a6'];

        function esc(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function lastMonths(n) {
            var out = [];
            var now = new Date();
            for (var i = n - 1; i >= 0; i--) {
                var d = new Date(now.getFullYear(), now.getMonth() - i, 1);
                out.push({
                    key: d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0'),
                    label: d.toLocaleDateString('en-US', { month: 'short' })
                });
            }
            return out;
        }

        function renderBars(el, rows) {
            var months = lastMonths(6);
            var byKey = {};
            rows.forEach(function(r) { byKey[r.month] = parseInt(r.nb, 10) || 0; });
            var values = months.map(function(m) { return { label: m.label, value: byKey[m.key] || 0 }; });
            var max = Math.max.apply(null, values.map(function(v) { return v.value; })) || 1;
            var html = '<div class="bars">';
            values.forEach(function(v) {
                var pct = v.value > 0 ? Math.max(6, Math.round((v.value / max) * 100)) : 0;
                html += '<div class="bars__col">'
                    + '<div class="bars__bar-wrap"><div class="bars__bar' + (v.value === 0 ? ' bars__bar--muted' : '') + '" style="height:' + pct + '%" title="' + esc(v.label) + ' : ' + v.value + '"></div></div>'
                    + '<div class="bars__value">' + v.value + '</div>'
                    + '<div class="bars__label">' + esc(v.label) + '</div>'
                    + '</div>';
            });
            html += '</div>';
            el.innerHTML = html;
        }

        function renderDonut(el, rows, maxSlices) {
            var items = rows.slice(0, maxSlices);
            var rest = rows.slice(maxSlices);
            var restSum = rest.reduce(function(a, b) { return a + (parseInt(b.nb, 10) || 0); }, 0);
            if (restSum > 0) items.push({ label: 'Others', nb: restSum });
            var total = items.reduce(function(a, b) { return a + (parseInt(b.nb, 10) || 0); }, 0);
            if (total === 0) { el.innerHTML = '<p class="chart-empty">No data.</p>'; return; }
            var acc = 0;
            var stops = items.map(function(item, i) {
                var start = (acc / total) * 100;
                acc += parseInt(item.nb, 10) || 0;
                var end = (acc / total) * 100;
                return PALETTE[i % PALETTE.length] + ' ' + start + '% ' + end + '%';
            });
            var legend = items.map(function(item, i) {
                var pct = Math.round(((parseInt(item.nb, 10) || 0) / total) * 100);
                return '<li><span class="donut__dot" style="background:' + PALETTE[i % PALETTE.length] + '"></span>'
                    + '<span class="donut__label">' + esc(item.label) + '</span>'
                    + '<span class="donut__pct">' + pct + '%</span>'
                    + '<b>' + item.nb + '</b></li>';
            }).join('');
            el.innerHTML = '<div class="donut" style="background: conic-gradient(' + stops.join(', ') + ')"><div class="donut__hole"></div></div>'
                + '<ul class="donut__legend">' + legend + '</ul>';
        }

        // Horizontal bars
        function renderHBars(el, rows) {
            if (!rows.length) { el.innerHTML = '<p class="chart-empty">No data.</p>'; return; }
            var max = Math.max.apply(null, rows.map(function(r) { return parseInt(r.nb, 10) || 0; })) || 1;
            var html = '<div class="hbars">';
            rows.forEach(function(r) {
                var v = parseInt(r.nb, 10) || 0;
                var pct = Math.round((v / max) * 100);
                html += '<div class="hbar">'
                    + '<span class="hbar__label">' + esc(r.label) + '</span>'
                    + '<span class="hbar__value">' + v + '</span>'
                    + '<span class="hbar__track"><span class="hbar__fill" style="width:' + pct + '%"></span></span>'
                    + '</div>';
            });
            html += '</div>';
            el.innerHTML = html;
        }

        // Shared hover tooltip: shows label + count for the nearest data point
        function chartTip(container, svg, items) {
            var tip = document.createElement('div');
            tip.className = 'chart-tip';
            tip.setAttribute('role', 'tooltip');
            container.appendChild(tip);
            var W = svg.viewBox.baseVal.width, H = svg.viewBox.baseVal.height;
            svg.addEventListener('mousemove', function(ev) {
                var rect = svg.getBoundingClientRect();
                var mx = (ev.clientX - rect.left) / rect.width * W;
                var my = (ev.clientY - rect.top) / rect.height * H;
                var best = 0, bd = Infinity, i;
                for (i = 0; i < items.length; i++) {
                    var dx = items[i].x - mx, dy = items[i].y - my;
                    var d = dx * dx + dy * dy;
                    if (d < bd) { bd = d; best = i; }
                }
                var p = items[best];
                tip.textContent = p.label + ' : ' + p.value;
                tip.classList.add('is-visible');
                var px = p.x / W * rect.width;
                var py = p.y / H * rect.height;
                var left = Math.max(2, Math.min(rect.width - tip.offsetWidth - 2, px - tip.offsetWidth / 2));
                var top = py - tip.offsetHeight - 10;
                if (top < 0) { top = py + 10; }
                tip.style.left = left + 'px';
                tip.style.top = top + 'px';
                var dots = svg.querySelectorAll('.chart-dot');
                for (i = 0; i < dots.length; i++) { dots[i].classList.toggle('is-active', i === best); }
            });
            svg.addEventListener('mouseleave', function() {
                tip.classList.remove('is-visible');
                var dots = svg.querySelectorAll('.chart-dot');
                for (var i = 0; i < dots.length; i++) { dots[i].classList.remove('is-active'); }
            });
        }

        // Line chart (SVG)
        function renderLine(el, rows) {
            var months = lastMonths(12);
            var byKey = {};
            rows.forEach(function(r) { byKey[r.month] = parseInt(r.nb, 10) || 0; });
            var values = months.map(function(m) { return { label: m.label, value: byKey[m.key] || 0 }; });
            var max = Math.max.apply(null, values.map(function(v) { return v.value; })) || 1;
            var W = 320, H = 140, pad = 8, topPad = 16;
            var innerH = H - topPad - pad;
            var stepX = (W - pad * 2) / (values.length - 1);
            var pts = values.map(function(v, i) {
                return { x: pad + i * stepX, y: topPad + innerH - (v.value / max) * innerH, v: v };
            });
            var line = pts.map(function(p) { return p.x.toFixed(1) + ',' + p.y.toFixed(1); }).join(' ');
            var area = 'M' + pts[0].x.toFixed(1) + ',' + (H - pad) + ' L' + line.replace(/ /g, ' L') + ' L' + pts[pts.length - 1].x.toFixed(1) + ',' + (H - pad) + ' Z';
            var html = '<div class="line-wrap">'
                + '<svg class="line-chart" viewBox="0 0 ' + W + ' ' + H + '" role="img" aria-label="Loan evolution over 12 months">'
                + '<defs><linearGradient id="line-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="var(--primary)" stop-opacity="0.28"/><stop offset="100%" stop-color="var(--primary)" stop-opacity="0.02"/></linearGradient></defs>'
                + '<path d="' + area + '" fill="url(#line-fill)"/>'
                + '<polyline points="' + line + '" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                + pts.map(function(p) { return '<circle class="chart-dot" cx="' + p.x.toFixed(1) + '" cy="' + p.y.toFixed(1) + '" r="3" fill="var(--surface-1)" stroke="var(--primary)" stroke-width="1.6"></circle>'; }).join('')
                + '</svg>'
                + '<div class="line-labels">' + values.map(function(v) { return '<span>' + esc(v.label) + '</span>'; }).join('') + '</div>'
                + '</div>';
            el.innerHTML = html;
            chartTip(el.querySelector('.line-wrap'), el.querySelector('.line-chart'), pts.map(function(p) { return { x: p.x, y: p.y, label: p.v.label, value: p.v.value }; }));
        }

        // Pie chart (SVG, slices)
        function renderPie(el, rows, maxSlices) {
            var items = rows.slice(0, maxSlices);
            var rest = rows.slice(maxSlices);
            var restSum = rest.reduce(function(a, b) { return a + (parseInt(b.nb, 10) || 0); }, 0);
            if (restSum > 0) items.push({ label: 'Others', nb: restSum });
            var total = items.reduce(function(a, b) { return a + (parseInt(b.nb, 10) || 0); }, 0);
            if (total === 0) { el.innerHTML = '<p class="chart-empty">No data.</p>'; return; }
            var cx = 80, cy = 80, r = 72;
            var acc = 0;
            var slices = [];
            var paths = items.map(function(item, i) {
                var nb = parseInt(item.nb, 10) || 0;
                if (nb <= 0) { return ''; }
                var start = acc / total;
                acc += nb;
                var end = acc / total;
                var a0 = 2 * Math.PI * start - Math.PI / 2;
                var a1 = 2 * Math.PI * end - Math.PI / 2;
                var x1 = cx + r * Math.cos(a0);
                var y1 = cy + r * Math.sin(a0);
                var x2 = cx + r * Math.cos(a1);
                var y2 = cy + r * Math.sin(a1);
                var large = (end - start) > 0.5 ? 1 : 0;
                var d;
                if ((end - start) >= 0.99999) {
                    // A single slice covering the whole pie: draw a full circle
                    d = 'M' + (cx - r) + ',' + cy + ' A' + r + ',' + r + ' 0 1 1 ' + (cx + r) + ',' + cy + ' A' + r + ',' + r + ' 0 1 1 ' + (cx - r) + ',' + cy + ' Z';
                } else {
                    d = 'M' + cx + ',' + cy + ' L' + x1.toFixed(2) + ',' + y1.toFixed(2)
                        + ' A' + r + ',' + r + ' 0 ' + large + ' 1 ' + x2.toFixed(2) + ',' + y2.toFixed(2) + ' Z';
                }
                var mid = (a0 + a1) / 2;
                slices.push({ x: cx + r * 0.62 * Math.cos(mid), y: cy + r * 0.62 * Math.sin(mid), label: item.label, value: nb });
                return '<path d="' + d + '" fill="' + PALETTE[i % PALETTE.length] + '" stroke="var(--surface-1)" stroke-width="1.5"></path>';
            }).join('');
            var legend = items.map(function(item, i) {
                var pct = Math.round(((parseInt(item.nb, 10) || 0) / total) * 100);
                return '<li><span class="donut__dot" style="background:' + PALETTE[i % PALETTE.length] + '"></span>'
                    + '<span class="donut__label">' + esc(item.label) + '</span>'
                    + '<span class="donut__pct">' + pct + '%</span>'
                    + '<b>' + item.nb + '</b></li>';
            }).join('');
            el.innerHTML = '<div class="pie-wrap"><svg viewBox="0 0 160 160" class="pie" role="img" aria-label="Pie chart">' + paths + '</svg></div>'
                + '<ul class="donut__legend">' + legend + '</ul>';
            chartTip(el.querySelector('.pie-wrap'), el.querySelector('.pie-wrap svg'), slices);
        }

        // Gauge (SVG, half-circle)
        function renderGauge(el, o) {
            var total = parseInt(o.total, 10) || 0;
            var value = parseInt(o.on_loan, 10) || 0;
            var pct = total > 0 ? Math.round((value / total) * 100) : 0;
            var cx = 110, cy = 110, r = 88;
            var sweep = Math.PI * (pct / 100);
            function arcPath(a0, a1) {
                var large = (a1 - a0) > Math.PI ? 1 : 0;
                var x0 = cx + r * Math.cos(a0);
                var y0 = cy + r * Math.sin(a0);
                var x1 = cx + r * Math.cos(a1);
                var y1 = cy + r * Math.sin(a1);
                return 'M' + x0.toFixed(2) + ',' + y0.toFixed(2) + ' A' + r + ',' + r + ' 0 ' + large + ' 1 ' + x1.toFixed(2) + ',' + y1.toFixed(2);
            }
            var html = '<div class="gauge-wrap">'
                + '<svg viewBox="0 0 220 130" class="gauge" role="img" aria-label="Rate of books on loan : ' + pct + ' %">'
                + '<path d="' + arcPath(Math.PI, 0) + '" fill="none" stroke="var(--surface-3)" stroke-width="14" stroke-linecap="round"/>'
                + (sweep > 0 ? '<path d="' + arcPath(Math.PI, Math.PI + sweep) + '" fill="none" stroke="var(--primary)" stroke-width="14" stroke-linecap="round"/>' : '')
                + '</svg>'
                + '<div class="gauge__value">' + pct + '%</div>'
                + '<div class="gauge__meta">' + value + ' of ' + total + ' books on loan</div>'
                + '</div>';
            el.innerHTML = html;
        }

        function chartError(el) {
            el.innerHTML = '<p class="chart-empty"><svg class="icon"><use href="#i-alert"/></svg> Unable to load data.</p>';
        }

        function loadCharts() {
            var chartIds = ['chart-monthly', 'chart-evolution', 'chart-borrowers', 'chart-status', 'chart-users-classes', 'chart-occupation'];
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'actions/others/stats_data.php', true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    try {
                        var d = JSON.parse(xhr.responseText);
                        renderBars(document.getElementById('chart-monthly'), d.monthly_loans || []);
                        renderLine(document.getElementById('chart-evolution'), d.evolution_12_months || []);
                        renderHBars(document.getElementById('chart-borrowers'), d.top_borrowers || []);
                        renderPie(document.getElementById('chart-status'), d.loans_by_status || [], 10);
                        renderDonut(document.getElementById('chart-users-classes'), d.users_by_class || [], 8);
                        renderGauge(document.getElementById('chart-occupation'), d.books_occupancy || { on_loan: 0, total: 0 });
                    } catch (e) {
                        console.error('Error parsing statistics', e);
                        chartIds.forEach(function(id) { chartError(document.getElementById(id)); });
                    }
                } else {
                    console.error('Error in AJAX response (statistics): HTTP ' + xhr.status);
                    chartIds.forEach(function(id) { chartError(document.getElementById(id)); });
                }
            };
            xhr.onerror = function() {
                console.error('AJAX network error (statistics)');
                chartIds.forEach(function(id) { chartError(document.getElementById(id)); });
            };
            xhr.send();
        }

        updateCounters();
        setInterval(updateCounters, 10000);
        loadCharts();
    </script>
    <?php include '../includes/footer.php'; ?>
</body>

</html>
