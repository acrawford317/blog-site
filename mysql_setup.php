<?php

    /** SETUP **/
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli("localhost", "root", "", "blog"); // XAMPP
    
    $db->query("drop table if exists user;");
    $db->query("create table user (
        id int not null auto_increment,
        username text not null,
        password text not null,
        primary key (id));");
    
    $db->query("drop table if exists category;");
    $db->query("create table category (
        id int not null auto_increment,
        name text not null,
        primary key (id));");

    $db->query("drop table if exists post;");
    $db->query("create table post (
        id int not null auto_increment,
        category text not null,
        author text not null,
        title text not null,
        content text not null,
        image_file text not null,
        popular int not null default 0,
        created datetime not null default current_timestamp(),
        primary key (id))");

    $db->query("drop table if exists comment;");
    $db->query("create table comment (
        id int not null auto_increment,
        author text not null,
        content text not null,
        created datetime not null default current_timestamp(),
        primary key (id));");
    
    $db->query("drop table if exists reply;");
    $db->query("create table reply (
        id int not null auto_increment,
        author text not null,
        content text not null,
        comment_id int not null,
        created datetime not null default current_timestamp(),
        primary key (id));");

    
    $sql = "INSERT INTO category (name) VALUES ('Food'), ('Lifestyle'), ('Travel')";
    $db->query($sql);

    $sql = "INSERT INTO post (category, author, title, content, image_file, popular) VALUES ('lifestyle', 'Ashley Crawford', 'My First Post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum. Non diam phasellus vestibulum lorem sed risus ultricies. Donec et odio pellentesque diam volutpat commodo sed egestas egestas. A cras semper auctor neque. Sed cras ornare arcu dui vivamus arcu felis bibendum ut. Duis convallis convallis tellus id. Ut etiam sit amet nisl purus in mollis. Mauris rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque. In ante metus dictum at tempor commodo ullamcorper a. Ac turpis egestas maecenas pharetra convallis. Faucibus scelerisque eleifend donec pretium vulputate sapien. At in tellus integer feugiat scelerisque varius morbi. Commodo quis imperdiet massa tincidunt nunc pulvinar sapien. Habitasse platea dictumst quisque sagittis purus sit amet. \r\n 
    Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Facilisis sed odio morbi quis commodo odio aenean sed. Pulvinar mattis nunc sed blandit libero. Posuere morbi leo urna molestie at elementum eu. Neque laoreet suspendisse interdum consectetur. Ipsum faucibus vitae aliquet nec ullamcorper sit. Nunc sed augue lacus viverra vitae. Volutpat maecenas volutpat blandit aliquam etiam erat. Consequat mauris nunc congue nisi. Rhoncus urna neque viverra justo nec ultrices dui. Leo duis ut diam quam nulla porttitor massa id. Ullamcorper a lacus vestibulum sed arcu non odio euismod lacinia. Nisi quis eleifend quam adipiscing vitae proin sagittis nisl rhoncus. Mauris sit amet massa vitae tortor condimentum lacinia quis. \r\n 
    Vulputate ut pharetra sit amet aliquam id diam maecenas ultricies. Cras semper auctor neque vitae. Quam quisque id diam vel. Tristique risus nec feugiat in fermentum posuere urna nec tincidunt. Fermentum et sollicitudin ac orci phasellus egestas tellus rutrum tellus. Maecenas volutpat blandit aliquam etiam. Porttitor eget dolor morbi non arcu risus quis. Et sollicitudin ac orci phasellus. Ornare arcu odio ut sem. Vel pretium lectus quam id. \r\n 
    Vitae congue mauris rhoncus aenean vel elit. Feugiat pretium nibh ipsum consequat nisl vel pretium lectus quam. Cursus eget nunc scelerisque viverra mauris in aliquam sem fringilla. A diam maecenas sed enim. Luctus venenatis lectus magna fringilla urna porttitor rhoncus. Augue ut lectus arcu bibendum at varius vel. Malesuada bibendum arcu vitae elementum curabitur vitae nunc. Nisi lacus sed viverra tellus in. Erat nam at lectus urna duis convallis convallis tellus id. Elit sed vulputate mi sit amet mauris commodo quis imperdiet. Sit amet consectetur adipiscing elit pellentesque habitant morbi tristique senectus. Et ultrices neque ornare aenean euismod elementum nisi. Orci phasellus egestas tellus rutrum tellus pellentesque eu. Massa enim nec dui nunc mattis. \r\n 
    Venenatis cras sed felis eget velit aliquet sagittis. Vitae auctor eu augue ut lectus. Arcu cursus euismod quis viverra nibh cras pulvinar. Tincidunt augue interdum velit euismod in pellentesque massa. Gravida cum sociis natoque penatibus et. Dis parturient montes nascetur ridiculus mus mauris. Eget dolor morbi non arcu risus quis. Ut etiam sit amet nisl purus in mollis nunc. In cursus turpis massa tincidunt dui. Sodales ut eu sem integer vitae justo eget magna fermentum. Magna etiam tempor orci eu lobortis. Neque vitae tempus quam pellentesque nec nam aliquam sem. Amet commodo nulla facilisi nullam vehicula. Vestibulum lectus mauris ultrices eros. Erat imperdiet sed euismod nisi porta lorem mollis aliquam ut. Ac turpis egestas maecenas pharetra convallis posuere morbi. Malesuada proin libero nunc consequat interdum varius sit amet mattis. Mi tempus imperdiet nulla malesuada. In metus vulputate eu scelerisque felis. Dignissim diam quis enim lobortis.', 'biking.jpg', 0),
    ('food', 'Caitlin Crawford', 'Favorite Recipe', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis at tellus at urna condimentum mattis pellentesque id. Sed viverra tellus in hac habitasse platea dictumst vestibulum. At urna condimentum mattis pellentesque id. Lectus proin nibh nisl condimentum id. Accumsan sit amet nulla facilisi morbi. Lorem ipsum dolor sit amet consectetur adipiscing elit duis tristique. Dictum non consectetur a erat nam at lectus. Facilisi morbi tempus iaculis urna id volutpat. Euismod elementum nisi quis eleifend quam adipiscing vitae proin sagittis. Nibh praesent tristique magna sit amet purus gravida quis blandit. \r\n 
    Consectetur libero id faucibus nisl. Non quam lacus suspendisse faucibus. Nisl suscipit adipiscing bibendum est ultricies integer quis auctor elit. Cras pulvinar mattis nunc sed. Viverra orci sagittis eu volutpat odio. Tristique senectus et netus et malesuada. Elementum sagittis vitae et leo duis ut. Cursus turpis massa tincidunt dui ut ornare. Enim sed faucibus turpis in eu mi bibendum. Id eu nisl nunc mi. Odio ut sem nulla pharetra diam sit amet nisl. Elit pellentesque habitant morbi tristique senectus et netus. \r\n 
    Tellus molestie nunc non blandit massa enim. Sapien eget mi proin sed libero enim sed faucibus. Curabitur gravida arcu ac tortor dignissim convallis aenean et tortor. Purus ut faucibus pulvinar elementum integer enim neque volutpat ac. Venenatis lectus magna fringilla urna porttitor rhoncus dolor. Egestas congue quisque egestas diam in. Sed cras ornare arcu dui. Blandit libero volutpat sed cras. Orci a scelerisque purus semper eget duis at tellus. At varius vel pharetra vel turpis. Arcu felis bibendum ut tristique. Faucibus vitae aliquet nec ullamcorper sit amet. Quisque egestas diam in arcu cursus euismod. Odio euismod lacinia at quis risus sed. Sagittis aliquam malesuada bibendum arcu.', 'food.jpg', 1),
    ('travel', 'Jack Crawford', 'My Trip To Ireland', 'aknefalkwenf', 'ireland.jpg', 1),
    ('travel', 'Ashley Crawford', 'England Vacation', 'eklNFKLwenf', 'england.jpg', 1)";
    $db->query($sql);

