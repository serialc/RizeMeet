<div class="container-fluid footer bg-dark-subtle">
    <div class="container">
        <footer class="pt-4 mt-5 text-body-secondary">
            <div class="row">
                <div class="col-md-4 mt-3">
<?php
if (file_exists(SITE_PATH . 'foot_left.md')) {
    echo $parsedown->text(file_get_contents(SITE_PATH . 'foot_left.md'));
} else {
    echo '<p>Customize ' . SITE_PATH . 'foot_left.md</p>';
}
?>
                </div>

                <div class="col-md-4 mt-3">
<?php
if (file_exists(SITE_PATH . 'foot_middle.md')) {
    echo $parsedown->text(file_get_contents(SITE_PATH . 'foot_middle.md'));
} else {
    echo '<p>Customize ' . SITE_PATH . 'foot_middle.md</p>';
}
?>
                </div>

                <div class="col-md-4 mt-3">
<?php
if (file_exists(SITE_PATH . 'foot_right.md')) {
    echo $parsedown->text(file_get_contents(SITE_PATH . 'foot_right.md'));
} else {
    echo '<p>Customize ' . SITE_PATH . 'foot_right.md</p>';
}
?>
                </div>

                <div class="col-12 mt-5 text-center" style="font-size: 0.7em">
                    <p> <a href="/unsubscribe/form">mailing list unsubscribe</a> <p>

                    <p> <a href="https://github.com/serialc/RizeMeet">RizeMeet</a> facilitates meeting management and coordination.<br>
                        Copyright &copy;

<?php

$today = new \DateTime(date('Y-m-d'));
echo $today->format('Y');

?>

 RizeMeet - <a href='LICENSE'>GNU General Public License</a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <div class="text-end p-4" style="font-size: 0.7em"><a class="text-decoration-none" href="/admin" style="color: #888">&pi;</a></div>
</div>
<script src="/js/rm.js"></script>
</body>
</html>

