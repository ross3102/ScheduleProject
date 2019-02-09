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
    clean();
    global $db;

    $query = "select task_id, task_name, DATE_FORMAT(task_date, '%b %d, %Y') as task_date, task_completed, category_id
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
    clean();
    global $db;

    $query = "select task_id, task_name, DATE_FORMAT(task_date, '%e %M, %Y') as form_date, DATE_FORMAT(task_date, '%c/%e/%Y') as table_date, task_completed
              from task_list_task
              where category_id = :category_id
              order by task_date, task_id";
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

function get_task_list($user_id) {
    clean();
    global $db;

    $query = "select task_id, task_name, DATE_FORMAT(task_date, '%e %M, %Y') as form_date, DATE_FORMAT(task_date, '%c/%e/%Y') as table_date, DATE_FORMAT(task_date, '%c/%e/%y') as short_date, task_completed, c.category_id, c.category_name, c.category_color
              from task_list_task t, task_list_category c
              where t.category_id = c.category_id
              and user_id = :user_id
              order by task_date, c.category_name, task_name";
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

function add_category($user_id, $category_name, $category_color) {
    global $db;

    $query = "insert into task_list_category (user_id, category_name, category_color)
              values (:user_id, :category_name, :category_color)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':category_name', $category_name);
        $statement->bindValue(':category_color', $category_color);
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

function edit_category($category_id, $category_name) {
    global $db;

    $query = "update task_list_category
              set category_name = :category_name
              where category_id = :category_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':category_name', $category_name);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function change_color($category_id, $category_color) {
    global $db;

    $query = "update task_list_category
              set category_color = :category_color
              where category_id = :category_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':category_color', $category_color);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function edit_task($task_id, $task_name, $task_date, $category_id) {
    global $db;

    $query = "update task_list_task
              set task_name = :task_name,
              task_date = :task_date,
              category_id = :category_id
              where task_id = :task_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->bindValue(':task_name', $task_name);
        $statement->bindValue(':task_date', $task_date);
        $statement->bindValue(':category_id', $category_id);
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
              delete from task_list_category
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

function clean() {
    global $db;

    $query = "delete from task_list_task
              where task_completed = 1";

    try {
        $statement = $db->prepare($query);
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

function collapse($category_id, $category_active) {
    global $db;

    $query = "update task_list_category
              set category_active = :category_active
              where category_id = :category_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_active', $category_active);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}