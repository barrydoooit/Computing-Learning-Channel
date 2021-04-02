<?php if (isset($_SESSION['welcome-msg'])) : ?>
    <div class="welcome-msg" id="welcome-msg"></div>
    <script>
        let msgElement = document.getElementById('welcome-msg');
        let msg = document.createTextNode("<?php echo $_SESSION['welcome-msg']; ?>");
        msgElement.appendChild(msg);
        setTimeout(function() {
            var op = 1;
            var timer = setInterval(function() {
                if (op <= 0.1) {
                    clearInterval(timer);
                    msgElement.style.display = 'none';
                }
                msgElement.style.opacity = op;
                msgElement.style.filter = 'alpha(opacity=' + op * 100 + ")";
                op -= op * 0.1;
            }, 50);
        }, 3000);
    </script>
    <?php unset($_SESSION['welcome-msg']); ?>
<?php endif; ?>