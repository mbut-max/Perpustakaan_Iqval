<?php if(isset($_SESSION['user'])): ?>
    </div>
</div>
<?php else: ?>
</div>
<?php endif; ?>
<div id="cyberAlert" class="cyber-alert">
    SYSTEM READY ✔
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
setTimeout(()=>{
    document.getElementById("cyberAlert").classList.add("show");
    setTimeout(()=>{
        document.getElementById("cyberAlert").classList.remove("show");
    },3000);
},1500);

window.addEventListener("load", function(){
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "none";
    }
});

window.addEventListener('pageshow', function(event) {
    const navEntries = performance.getEntriesByType('navigation');
    const isBackForward = event.persisted || (navEntries[0] && navEntries[0].type === 'back_forward');
    if (isBackForward) {
        window.location.reload();
    }
});
</script>

</body>
</html>