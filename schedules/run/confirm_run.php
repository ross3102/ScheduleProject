<?php writeHeader() ?>

<div class="container">
    <h3 class="title"><?php echo $schedule["schedule_name"] ?></h3>
    <div class="center-align">
        <a href=".." class="waves-effect waves-light btn-large blue lighten-1">Cancel</a>
        <a href="./index.php?action=run&schedule_id=<?php echo $schedule_id ?>" class="waves-effect waves-light btn-large blue lighten-1">Confirm</a>
    </div>
    <table class="centered striped">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Item Duration</th>
                <th>Finish By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?php echo $item["item_name"] ?></td>
                    <td><?php echo int_to_duration($item["item_duration"]) ?></td>
                    <td id="<?php echo $item['item_id'] ?>"></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php writeFooter() ?>

<script>
    function updateTimes() {
        var time = new Date();
        <?php foreach ($items as $item) { ?>
            time = new Date(time.getTime() + <?php echo $item['item_duration'] ?> * 1000);
            $("#<?php echo $item['item_id'] ?>").html((time.getHours() - 1) % 12 + 1 + ":" + ("0" + time.getMinutes()).slice(-2) + ":"  + ("0" + time.getSeconds()).slice(-2));
        <?php } ?>
    }
    setInterval(updateTimes, 1)
</script>