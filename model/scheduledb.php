<?php

function get_schedule_by_id($schedule_id) {
    global $db;

    $query = "select *
    from schedule
    where schedule_id = :schedule_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':schedule_id', $schedule_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_item_by_id($item_id) {
    global $db;

    $query = "select *
    from item
    where item_id = :item_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_schedules_by_user_id($user_id) {
    global $db;

    $query = "select schedule_id, schedule_name
              from schedule
              where user_id = :user_id
              order by schedule_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_items_by_schedule_id($schedule_id) {
    global $db;

    $query = "select item_id, item_name, item_duration
              from item
              where schedule_id = :schedule_id
              order by item_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':schedule_id', $schedule_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_total_duration($schedule_id) {
    global $db;

    $query = "select sum(item_duration) as tot
              from item
              where schedule_id = :schedule_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':schedule_id', $schedule_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function add_schedule($user_id, $schedule_name) {
    global $db;

    $query = "insert into schedule (user_id, schedule_name)
              values (:user_id, :schedule_name)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':schedule_name', $schedule_name);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function add_item_to_schedule($schedule_id, $item_name, $item_duration) {
    global $db;

    $query = "insert into item (schedule_id, item_name, item_duration)
              values (:schedule_id, :item_name, :item_duration)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':schedule_id', $schedule_id);
        $statement->bindValue(':item_name', $item_name);
        $statement->bindValue(':item_duration', $item_duration);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function delete_schedule($schedule_id) {
    global $db;

    $query = "delete from item
              where schedule_id = :schedule_id;
              delete from schedule
              where schedule_id = :schedule_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':schedule_id', $schedule_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function delete_item($item_id) {
    global $db;

    $query = "delete from item
              where item_id = :item_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':item_id', $item_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}
