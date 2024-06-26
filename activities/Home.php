<?php 
namespace App;
use database\DataBase;
class Home{
    function index(){
        $db = new DataBase;
        $setting = $db->select('SELECT * FROM settings')->fetch();
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
        
        $topPostSelect = $db->select('SELECT posts.* 
        ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
        ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
        ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
         FROM posts WHERE posts.selected = 1 ORDER BY created_time DESC LIMIT 0,3')->fetchAll();
         
         $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 
         ORDER BY created_time DESC')->fetch();
        
        $lastPosts = $db->select('SELECT posts.* 
        ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
        ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
        ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
         FROM posts ORDER BY created_time DESC LIMIT 0,6')->fetchAll();
         
         $SelectedPosts = $db->select('SELECT posts.* 
         ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
         ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
         ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
          FROM posts WHERE posts.selected = 1 ORDER BY created_time DESC LIMIT 0,5')->fetchAll();
        
        $mostComments = $db->select('SELECT posts.* 
        ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
         FROM posts ORDER BY comment_count DESC LIMIT 0,4')->fetchAll();
         
         $bodyBanner = $db->select('SELECT * FROM banners ORDER BY created_time DESC LIMIT 0,1')->fetch();

         $mostViewPost = $db->select('SELECT posts.* 
         ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
         ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
         ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
          FROM posts WHERE posts.selected = 1 ORDER BY view DESC LIMIT 0,3')->fetchAll();

        $sideBanner = $db->select('SELECT * FROM banners ORDER BY created_time DESC LIMIT 0,1')->fetch(); 
        
         require_once  BASE_PATH . '/template/app/index.php';
    }
    function post($id){
      $db = new DataBase;
      $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();

      $sideBanner = $db->select('SELECT * FROM banners ORDER BY created_time DESC LIMIT 0,1')->fetch(); 
      $post= $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
      ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
       FROM posts WHERE id = ? ',[$id])->fetch();
      $db->update('posts',$id,['view'],[$post['view']+1]);
      $SelectedPosts = $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
      ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
      FROM posts WHERE posts.selected = 1 ORDER BY created_time DESC LIMIT 0,5')->fetchAll();

      $mostComments = $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      FROM posts ORDER BY comment_count DESC LIMIT 0,4')->fetchAll();

      $comments = $db->select('SELECT comments.* , users.username FROM comments LEFT JOIN users 
      ON comments.user_id = users.id WHERE status = "approved" AND comments.post_id = ?',[$id])->fetchAll();

      require_once  BASE_PATH . '/template/app/post.php';

    }
    function commentStore($request,$id){
     
      $db = new DataBase;
      $request['post_id'] = $id;
      $request['user_id'] = $_SESSION['user'];
      $db->insert('comments', array_keys($request), array_values($request));
      header('Location:' . $_SERVER['HTTP_REFERER']);
    }
    function category($id){
      $db = new DataBase;
      $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
      $bodyBanner = $db->select('SELECT * FROM banners ORDER BY created_time DESC LIMIT 0,1')->fetch();

      $SelectedPosts = $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
      ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
      FROM posts WHERE posts.selected = 1 ORDER BY created_time DESC LIMIT 0,5')->fetchAll();

      $mostComments = $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      FROM posts ORDER BY comment_count DESC LIMIT 0,4')->fetchAll();

      $lastPosts = $db->select('SELECT posts.* 
      ,(SELECT COUNT(*) FROM comments WHERE posts.id = comments.post_id AND status = "approved") AS comment_count
      ,(SELECT title FROM categories WHERE posts.cat_id = categories.id) AS cat_title 
      ,(SELECT username FROM users WHERE posts.user_id = users.id) AS username
      FROM posts WHERE (cat_id = ?) ORDER BY created_time DESC LIMIT 0,6',[$id])->fetchAll();

      require_once  BASE_PATH . '/template/app/category.php';
    }
}
