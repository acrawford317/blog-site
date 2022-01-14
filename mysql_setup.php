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
        post_id int not null,
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
    ('travel', 'Jack Crawford', 'My Trip To Ireland', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vestibulum mattis ullamcorper velit sed ullamcorper. Sit amet consectetur adipiscing elit. Sit amet massa vitae tortor condimentum. Amet risus nullam eget felis eget nunc lobortis. Lectus proin nibh nisl condimentum. Etiam non quam lacus suspendisse faucibus interdum posuere lorem. Eget dolor morbi non arcu risus. Viverra vitae congue eu consequat. Donec adipiscing tristique risus nec feugiat in fermentum posuere urna. Praesent elementum facilisis leo vel fringilla est ullamcorper eget nulla. Ut placerat orci nulla pellentesque dignissim enim sit amet. In nulla posuere sollicitudin aliquam ultrices. Nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit. Fermentum leo vel orci porta non pulvinar neque laoreet. Porttitor massa id neque aliquam. \r\n  
    Feugiat in fermentum posuere urna nec. Nunc sed velit dignissim sodales ut eu. Gravida arcu ac tortor dignissim convallis aenean. Nec sagittis aliquam malesuada bibendum. Feugiat pretium nibh ipsum consequat nisl vel pretium lectus quam. Cras semper auctor neque vitae tempus quam. At urna condimentum mattis pellentesque id nibh tortor. Dolor sed viverra ipsum nunc aliquet. Egestas integer eget aliquet nibh. Quam quisque id diam vel quam elementum. Venenatis urna cursus eget nunc scelerisque viverra mauris. Tristique senectus et netus et. Ut tellus elementum sagittis vitae et leo. Ipsum dolor sit amet consectetur adipiscing elit duis tristique sollicitudin. Hendrerit gravida rutrum quisque non tellus. Neque vitae tempus quam pellentesque nec nam aliquam. Vel pretium lectus quam id leo in vitae. Blandit turpis cursus in hac habitasse platea dictumst. \r\n  
    Nunc id cursus metus aliquam eleifend mi. Posuere urna nec tincidunt praesent semper feugiat nibh sed. Porttitor leo a diam sollicitudin tempor id. Justo nec ultrices dui sapien eget mi proin sed libero. Elementum sagittis vitae et leo duis ut diam quam nulla. Semper quis lectus nulla at volutpat diam ut venenatis tellus. Etiam tempor orci eu lobortis elementum nibh tellus. Pharetra pharetra massa massa ultricies mi quis hendrerit dolor magna. Ipsum dolor sit amet consectetur. Ac feugiat sed lectus vestibulum mattis. Duis at consectetur lorem donec massa. Sollicitudin aliquam ultrices sagittis orci a.', 'ireland.jpg', 1),
    ('travel', 'Ashley Crawford', 'England Vacation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Luctus accumsan tortor posuere ac ut consequat semper. In nisl nisi scelerisque eu ultrices vitae auctor eu. In hac habitasse platea dictumst. Sit amet dictum sit amet justo donec. Fringilla urna porttitor rhoncus dolor purus non enim. Odio eu feugiat pretium nibh. Amet luctus venenatis lectus magna. Pharetra massa massa ultricies mi quis hendrerit dolor magna. Et tortor at risus viverra. Non quam lacus suspendisse faucibus interdum. Convallis posuere morbi leo urna molestie at elementum. Dis parturient montes nascetur ridiculus mus mauris vitae. Ut etiam sit amet nisl purus in mollis nunc sed. Id cursus metus aliquam eleifend mi in nulla posuere. In iaculis nunc sed augue lacus. Nibh venenatis cras sed felis eget. Nisl vel pretium lectus quam id leo in. Lorem ipsum dolor sit amet. Blandit libero volutpat sed cras. \r\n 
    Amet nulla facilisi morbi tempus iaculis. Donec ultrices tincidunt arcu non sodales. Consectetur adipiscing elit pellentesque habitant morbi tristique. Lobortis scelerisque fermentum dui faucibus. Nulla aliquet enim tortor at auctor urna nunc id. Mauris cursus mattis molestie a iaculis at erat pellentesque. Sit amet volutpat consequat mauris nunc congue nisi vitae. Ut morbi tincidunt augue interdum velit euismod in pellentesque. Praesent tristique magna sit amet purus gravida quis blandit. Libero enim sed faucibus turpis in eu mi. Ac tortor vitae purus faucibus ornare suspendisse sed nisi. Arcu non odio euismod lacinia at quis risus sed. Tellus in metus vulputate eu scelerisque felis. Mauris a diam maecenas sed enim ut. Nisl condimentum id venenatis a condimentum. Sit amet cursus sit amet dictum sit amet justo donec. Auctor augue mauris augue neque gravida in fermentum et. Lectus vestibulum mattis ullamcorper velit sed. Neque convallis a cras semper auctor neque vitae tempus. \r\n  
    Faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis. Sed blandit libero volutpat sed cras. Sed libero enim sed faucibus turpis in eu mi. Gravida cum sociis natoque penatibus et magnis. Morbi tristique senectus et netus et malesuada fames. Mi sit amet mauris commodo quis imperdiet massa tincidunt. Ut placerat orci nulla pellentesque. Aenean euismod elementum nisi quis. Ultricies mi eget mauris pharetra et ultrices. Platea dictumst vestibulum rhoncus est. Urna neque viverra justo nec ultrices dui sapien eget mi. \r\n 
    Sed velit dignissim sodales ut eu sem integer. Tellus integer feugiat scelerisque varius morbi enim nunc. Fames ac turpis egestas maecenas pharetra convallis. Sem viverra aliquet eget sit amet tellus. Eu non diam phasellus vestibulum. Arcu non sodales neque sodales ut etiam sit. Sollicitudin ac orci phasellus egestas tellus rutrum tellus pellentesque eu. Sapien eget mi proin sed libero enim. Porttitor massa id neque aliquam vestibulum morbi blandit cursus risus. Imperdiet nulla malesuada pellentesque elit eget. Tempus egestas sed sed risus pretium. Sed egestas egestas fringilla phasellus. Nam at lectus urna duis convallis convallis tellus id interdum. Feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Amet cursus sit amet dictum sit amet. Amet consectetur adipiscing elit ut aliquam purus. Vitae sapien pellentesque habitant morbi tristique senectus et. Pellentesque massa placerat duis ultricies.', 'england.jpg', 1)";
    $db->query($sql);

