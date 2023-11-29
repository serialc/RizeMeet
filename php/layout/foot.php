<?php

namespace frakturmedia\RizeMeet;

?>

<div class="container footer">
    <footer class="pt-4 mt-5 text-body-secondary border-top">
        <div class="row">

            <div class="col-md-4 mt-3">
<?php echo 'Display content of footer_left'; ?>
            </div>

            <div class="col-md-4 mt-3">
<?php echo 'Display content of footer_centre'; ?>
            </div>

            <div class="col-md-4 mt-3">
<?php echo 'Display content of footer_right'; ?>
            </div>

            <div class="col-12 mt-5 text-center" style="font-size: 0.7em">
                <p>
                    RizeMeet is a minimal CMS to facilitate meeting management and coordination.<br>
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

