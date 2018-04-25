<?php

function get_user_by_id($user_id) {
    global $db;

    $query = "select *
    from user, phpauth_users
    where id = user_id
    and id = :user_id";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}

function new_user($user_id, $first_name, $last_name, $username) {
    global $db;

    $query =
        "insert into user (user_id, user_first_name, user_last_name, username)
        values (:user_id, :user_first_name, :user_last_name, :username)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':user_first_name', $first_name);
        $statement->bindValue(':user_last_name', $last_name);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        echo ($e);
        exit();
    }
}