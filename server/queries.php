<?php

$SQL_50_First_tags = "SELECT * FROM `tags` LIMIT 50";

$SQL_50_First_Users = "SELECT * FROM `users` LIMIT 50";

$SQL_getUserFromId = "SELECT * FROM `users` WHERE id= '$userId' ";

$SQL_Get_Subscribed_Posts = "
    SELECT users.id as author_id, posts.content,
    posts.created,
    users.alias as author_name,  
    count(likes.id) as like_number,  
    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
    FROM followers 
    JOIN users ON users.id=followers.followed_user_id
    JOIN posts ON posts.user_id=users.id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    WHERE followers.following_user_id='$userId' 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    ";

$SQL_followers = "
    SELECT users.*
    FROM followers
    LEFT JOIN users ON users.id=followers.following_user_id
    WHERE followers.followed_user_id='$userId'
    GROUP BY users.id
    ";

$SQL_news = "
    SELECT users.id as author_id, posts.content,
    posts.created,
    users.alias as author_name,  
    count(likes.id) as like_number,  
    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
    FROM posts
    JOIN users ON  users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    LIMIT 5
    ";

$SQL_wall = "
    SELECT users.id as author_id, posts.content, posts.created, users.alias as author_name, 
    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
    FROM posts
    JOIN users ON  users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    WHERE posts.user_id='$userId' 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    ";
$SQL_tags = "
    SELECT tags.id as tag_id, users.id as author_id, posts.content,
    posts.created,
    users.alias as author_name,  
    count(likes.id) as like_number,  
    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
    FROM posts_tags as filter 
    JOIN posts ON posts.id=filter.post_id
    JOIN users ON users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    WHERE filter.tag_id = '$tagId' 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    ";
$SQL_Subs = "
    SELECT users.* 
    FROM followers 
    LEFT JOIN users ON users.id=followers.followed_user_id 
    WHERE followers.following_user_id='$userId'
    GROUP BY users.id
    ";
$SQL_settings = "
    SELECT users.*, 
    count(DISTINCT posts.id) as totalpost, 
    count(DISTINCT given.post_id) as totalgiven, 
    count(DISTINCT recieved.user_id) as totalrecieved 
    FROM users 
    LEFT JOIN posts ON posts.user_id=users.id 
    LEFT JOIN likes as given ON given.user_id=users.id 
    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
    WHERE users.id = '$userId' 
    GROUP BY users.id
    ";

?>