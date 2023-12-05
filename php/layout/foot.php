<?php

namespace frakturmedia\RizeMeet;

?>

<div class="container footer">
    <footer class="pt-4 mt-5 text-body-secondary border-top">
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
                <p>
                    <a href="https://github.com/serialc/RizeMeet">RizeMeet</a> is a minimal CMS facilitating meeting management and coordination.<br>
                    Copyright (C) 

<?php

$today = new \DateTime(date('Y-m-d'));
echo $today->format('Y');

?>

 Cyrille Médard de Chardon - <a href='LICENSE'>GNU General Public License</a>
                </p>
            </div>
        </div>
    </footer>
</div>

</body>
</html>

