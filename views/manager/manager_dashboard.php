<style>
    .md-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .md-stat-card {
        background: #fff;
        border: 1px solid var(--man-border);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .md-stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
    .md-stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .md-stat-icon svg { width: 28px; height: 28px; }
    
    .md-stat-info { flex: 1; min-width: 0; }
    .md-stat-num {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        color: var(--man-text);
        margin-bottom: 6px;
    }
    .md-stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-green { background: #f0fdf4; color: #22c55e; }
    .icon-amber { background: #fffbeb; color: #f59e0b; }

    .md-banner {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 20px;
        padding: 32px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .md-banner-content { position: relative; z-index: 2; max-width: 600px; }
    .md-banner h2 { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; }
    .md-banner p { font-size: 1.05rem; color: #cbd5e1; line-height: 1.5; }
    
    .md-banner-bg {
        position: absolute; right: 0; top: -50px;
        opacity: 0.1; width: 300px; height: 300px;
        color: #fff; z-index: 1;
    }

    @media (max-width: 900px) {
        .md-grid { grid-template-columns: 1fr; gap: 12px; }
        .md-banner { padding: 24px; }
    }
</style>

<div class="md-banner">
    <div class="md-banner-content">
        <h2><?= __('man_hello') ?> <span id="welcomeName"><?= __('man_top_manager') ?></span> 👋</h2>
        <p><?= __('man_welcome') ?></p>
    </div>
    <svg class="md-banner-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 18.5l-10-5V10l10 5 10-5v5.5l-10 5z"/></svg>
</div>

<div class="md-grid">
    <div class="md-stat-card">
        <div class="md-stat-icon icon-amber">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statNewLeads">—</div>
            <div class="md-stat-label"><?= __('man_stat_free_leads') ?></div>
        </div>
    </div>
    
    <div class="md-stat-card cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>/manager/leads'" style="cursor: pointer;">
        <div class="md-stat-icon icon-blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statMyLeads">—</div>
            <div class="md-stat-label"><?= __('man_stat_my_leads') ?></div>
        </div>
    </div>

    <div class="md-stat-card cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>/manager/students'" style="cursor: pointer;">
        <div class="md-stat-icon icon-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <div class="md-stat-info">
            <div class="md-stat-num" id="statMyStudents">—</div>
            <div class="md-stat-label"><?= __('man_stat_my_students') ?></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const nameNode = document.getElementById('manName');
        if (nameNode && nameNode.textContent !== '<?= __('man_top_manager') ?>') {
            document.getElementById('welcomeName').textContent = nameNode.textContent.split(' ')[0]; // First name
        }
    }, 500);

    fetch(`${window.BASE_URL}/api/manager/dashboard-stats`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.stats) {
                document.getElementById('statNewLeads').textContent = data.stats.new_leads || 0;
                document.getElementById('statMyLeads').textContent = data.stats.my_leads || 0;
                document.getElementById('statMyStudents').textContent = data.stats.my_students || 0;
            }
        });
});
</script>
