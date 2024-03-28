<?php
require_once 'Model.php';

class Post extends Model {
    public $db;

    public function insert($title, $description, $author, $date, $imageInputName) {
        // checking if image was provided
        if (empty($_FILES[$imageInputName]['tmp_name']) || $_FILES[$imageInputName]['error'] === UPLOAD_ERR_NO_FILE) {
            $photo = null;
            $imageFormat = null;
        } elseif ($_FILES[$imageInputName]['error'] === UPLOAD_ERR_OK) {
            // Image provided and upload was successful
            // Extract image format
            $imageInfo = getimagesize($_FILES[$imageInputName]['tmp_name']);
            $imageFormat = $imageInfo['mime'];
    
            // Read binary data from image
            $photo = file_get_contents($_FILES[$imageInputName]["tmp_name"]);
            if ($photo === false) {
                return false;
            }
        } else {
            return false; // error
        }
    
        $query = "INSERT INTO post (title, description, author, date, image, imageFormat) VALUES (:title, :description, :author, :date, :image, :imageFormat)";
        $insertQuery = $this->db->prepare($query);
        if (!$insertQuery) {
            return false;
        }
        $insertQuery->bindParam(':title', $title);
        $insertQuery->bindParam(':description', $description);
        $insertQuery->bindParam(':author', $author);
        $insertQuery->bindParam(':date', $date);
        $insertQuery->bindParam(':image', $photo, PDO::PARAM_LOB);
        $insertQuery->bindParam(':imageFormat', $imageFormat);
    
        $result = $insertQuery->execute();
    
        return $result;
    }
    
    

    //returns true if successful
    public function delete($postId) {
        $query = "DELETE FROM post WHERE id = :post_id";
        $deleteQuery = $this->db->prepare($query);
        $deleteQuery->bindParam(':post_id', $postId);
        $result = $deleteQuery->execute();
        return $result;
    }

    public function extractImage($postId) {
        try {
            $query = "SELECT image FROM post WHERE id = :post_id";
            $query2 = "SELECT imageFormat FROM post WHERE id = :post_id";
            $takeImg = $this->db->prepare($query);
            $takeImg->bindParam(':post_id', $postId);
            $takeImg->execute();
            $takeImgFormat = $this->db->prepare($query2);
            $takeImgFormat->bindParam(':post_id', $postId);
            $takeImgFormat->execute();

            $imageData = $takeImg->fetchColumn();
            $imageFormat = $takeImgFormat->fetchColumn();
            
            //check the image data
            if ($imageData) {
                $base64Image = base64_encode($imageData);
                $imgSrc = "data:" . $imageFormat . ";base64," . $base64Image;
                
            } else {
                $imgSrc="../public/images/hello.svg";
            }
            return $imgSrc;
        } catch (PDOException $e) {
            return false;
        }
    }

    //return all posts as html elements
    public function getAllPosts() {
        $query = "SELECT post.*, users.username AS author_name FROM post JOIN users ON post.author = users.id";
        $posts = $this->db->query($query);
        $posts->setFetchMode(PDO::FETCH_ASSOC);
        $html = "";
        foreach ($posts as $post) {
            $imgSrc = $this->extractImage($post['id']);
            // Format date
            $date = date('F j, Y', strtotime($post['date']));
            $html .= "<a href='#' class='blog-article bg-white shadow-sm mb32' id='" .$post["id"]."'>";
            $html .= "<div class='blog-preview'>";
            $html .= "<img src='" . $imgSrc . "' width='258' height='200' alt='" . $post['title'] . "'>";
            $html .= "</div>";
            $html .= "<div class='blog-article-content'>";
            $html .= "<h2 class='h3 mb16 black'>" . $post['title'] . "</h2>";
            $html .= "<div class='blog-description gray mb24'>" . $post['description'] . "</div>";
            $html .= "<div class='blog-article-content-info flex caption gray'>";
            $html .= "<div class='flex'>";
            $html .= "<img src='../public/images/user.png' width='24' height='24' alt='author'>";
            $html .= "<span class='ml8 mr24'>" . $post['author_name'] . "</span>";
            $html .= "<span>" . $date . "</span>";
            $html .= "</div>";
            $html .= "<div class='interact flex'>";
            $html .= "<button class='like-btn'>";
            $html .= "<img src='../public/images/like.svg' alt='like'>";
            $html .= "<p>0</p>";
            $html .= "</button>";
            $html .= "<button>";
            $html .= "<img src='../public/images/comment.svg' alt='comment'>";
            $html .= "<p>0</p>";
            $html .= "</button>";
            $html .= "<button class='more-btn'><img src='../public/images/more.svg' alt='more'></button>";
            $html .= "<div class='dropdown-menu'>
                        <button class='edit-btn'>Edit</button>
                        <button class='delete-btn' data-post-id='" .$post["id"]."' >Delete</button>";
            $html .= "</div></div></div></div></a>";
        }
        return $html;
    }
    
    
}    
?>
