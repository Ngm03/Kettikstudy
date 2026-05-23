<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.style.transform === 'translateX(0px)') {
            sidebar.style.transform = 'translateX(-100%)';
            overlay.style.display = 'none';
        } else {
            sidebar.style.transform = 'translateX(0px)';
            overlay.style.display = 'block';
        }
    }
</script>
