<?php

function get_category_by_id($category_id) {
    global $db;

    $query = "select *
    from task_list_category
    where category_id = :category_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_task_by_id($task_id) {
    global $db;

    $query = "select task_id, task_name, DATE_FORMAT(task_date, '%b %d, %Y') as task_date, task_completed
    from task_list_task
    where task_id = :task_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_categories_by_user_id($user_id) {
    global $db;

    $query = "select *
              from task_list_category
              where user_id = :user_id
              order by category_id";
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

function get_tasks_by_category_id($category_id) {
    global $db;

    $query = "select task_id, task_name, DATE_FORMAT(task_date, '%b %d, %Y') as task_date, task_completed
              from task_list_task
              where category_id = :category_id
              order by task_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function get_total_tasks($category_id) {
    global $db;

    $query = "select count(*) as num
              from task_list_task
              where category_id = :category_id";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        $result = $result["num"];
        if ($result == 0) {
            return "<span style='font-style: italic; color: gray'>&lt;Empty&gt;</span>";
        } else if ($result == 1) {
            return $result . " Task";
        }
        return $result . " Tasks";
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function add_category($user_id, $category_name) {
    global $db;

    $query = "insert into task_list_category (user_id, category_name)
              values (:user_id, :category_name)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':category_name', $category_name);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function add_task_to_category($category_id, $task_name, $task_date) {
    global $db;

    $query = "insert into task_list_task (category_id, task_name, task_date)
              values (:category_id, :task_name, :task_date)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':task_name', $task_name);
        $statement->bindValue(':task_date', $task_date);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function delete_category($category_id) {
    global $db;

    $query = "delete from task_list_task
              where category_id = :category_id;
              delete from category
              where category_id = :category_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function delete_task($task_id) {
    global $db;

    $query = "delete from task_list_task
              where task_id = :task_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function complete($task_id, $task_completed) {
    global $db;

    $query = "update task_list_task
              set task_completed = :task_completed
              where task_id = :task_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_completed', $task_completed);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}