<?php
$head = "
<link rel='stylesheet' type='text/css' href='../css/column-flow.css'>
";
writeHeader($head) ?>
    <div class="container">
        <h3 class="title">Your Schedules</h3>
        <div class="center-align">
            <a href="#add_schedule" class="waves-effect waves-light btn modal-trigger">Add Schedule</a>
            <a href="./index.php?action=show_build_schedule" class="waves-effect waves-light btn">Build Schedule</a>
        </div>

        <div class="modal" id="add_schedule">
            <form action="." method="post">
                <div class="modal-content">
                    <div class="container">
                        <h3>Add Schedule</h3>
                        <input type="hidden" name="action" value="add_schedule">
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="schedule_name" name="schedule_name" class="validate" required>
                                <label for="schedule_name">Schedule Name</label>
                            </div>
                            <div class="input-field col s12">
                                <textarea id="schedule_desc" name="schedule_desc" class="validate materialize-textarea"></textarea>
                                <label for="schedule_desc">Schedule Description</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Add</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col s12 cards-container">
            <?php foreach ($schedules as $schedule) {
                $schedule_id = $schedule["schedule_id"];
                $schedule_name = $schedule["schedule_name"];
                $schedule_desc = $schedule["schedule_desc"];
                $items = get_items_by_schedule_id($schedule_id);
                $total_duration = get_total_duration($schedule_id)["tot"] ?>
                    <div class="card sticky-action z-depth-4">
                        <div class="card-content">
                            <div class="activator">
                                <span class="card-title activator"><?php echo $schedule_name ?></span>
                                <blockquote class=activator style="border-left: 5px solid #50ae54">
                                    <p class="activator"><?php echo $schedule_desc ?></p>
                                </blockquote>
                                <p class="activator"><?php echo int_to_duration($total_duration) ?></p>
                                <p class="activator"><?php echo count($items) . " Item" . (count($items) != 1 ? "s": "") ?></p>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" onclick="
                                event.stopPropagation();
                                confirmDeleteSchedule('<?php echo $schedule_name ?>', <?php echo $schedule_id ?>);"
                            >Delete</a>
                            <a href="#Add<?php echo $schedule_id ?>" class="modal-trigger">Add Item</a>
                            <a href='./index.php?action=run&schedule_id=<?php echo $schedule_id ?>'>Run</a>

                        </div>
                        <div class="card-reveal" style="overflow: hidden;">
                            <span class="card-title"><?php echo $schedule_name ?><i class="material-icons right">close</i></span>
                            <div class="reveal-content" style="overflow-y: scroll; height: 100%;">
                                <table class="highlight">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($items as $item) {
                                        $item_id = $item["item_id"];
                                        $item_name = $item["item_name"];
                                        $item_duration = $item["item_duration"]; ?>
                                        <tr>
                                            <td><?php echo $item_name ?></td>
                                            <td><?php echo int_to_duration($item_duration) ?></td>
                                            <td><i class="material-icons" onclick="
                                                    event.stopPropagation();
                                                    confirmDeleteItem('<?php echo $item_name ?>', <?php echo $item_id ?>, '<?php echo $schedule_name ?>')"
                                                >delete</i></td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div id="Add<?php echo $schedule_id ?>" class="modal">
                        <form action="." method="post">
                            <div class="modal-content">
                                <div class="container">
                                    <h3>Add Item</h3>
                                    <input type="hidden" name="action" value="add_item">
                                    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id ?>">
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input type="text" id="item_name" name="item_name" class="validate" required>
                                            <label for="item_name">Item Name</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input type="text" id="item_duration" name="item_duration" placeholder="HH:MM:SS" pattern="\d{1,2}:\d{2}:\d{2}" class="validate" required>
                                            <label for="item_duration" data-error="Enter a duration in the format HH:MM:SS or H:MM:SS">Item Duration</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#<?php echo $schedule_id ?>" class="modal-trigger modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                                <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Add</button>
                            </div>
                        </form>
                    </div>
            <?php } ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('.modal').modal();
            if ("<?php echo $modal ?>" !== "") {
                $("#<?php echo $modal ?>").modal("open");
            }
        });

        function delItem(item_id) {
            location.href='./index.php?action=delete_item&item_id=' + item_id;
        }

        function delSchedule(schedule_id) {
            location.href='./index.php?action=delete_schedule&schedule_id=' + schedule_id;
        }

        function confirmDeleteItem(item_name, item_id, schedule_name) {
            Materialize.toast('<span>Delete ' + item_name + ' from ' + schedule_name + '?</span><button class="btn-flat toast-action" onclick="delItem(' + item_id + ')">Confirm</button>', 10000);
        }

        function confirmDeleteSchedule(schedule_name, schedule_id) {
            Materialize.toast('<span>Delete schedule: ' + schedule_name + '?<span><button class="btn-flat toast-action" onclick="delSchedule(' + schedule_id + ')">Confirm</button>', 10000);
        }
    </script>

<?php writeFooter() ?>