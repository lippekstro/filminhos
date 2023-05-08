</main>
<footer></footer>

<script>
    <?php if (isset($_SESSION['msg'])) : ?>
        let toast = document.getElementById('toast')
        toast.className = 'show'
        setTimeout(function() {
            toast.className = toast.className.replace("show", "");
        }, 3000);
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
</script>
</body>

</html>