<?php
?>
<div class="container" id="flash">
    <?php $messages = showMessages();
    ?>
    <?php if ($messages) : ?>
        <?php foreach ($messages as $msg) : ?>
            <div class="alert alert-<?php echo isset($msg['color']) ? $msg['color'] : 'info'; ?>" role="alert">
  <?php 
  $imgSrc = '';
  switch ($msg['color']) {
    case 'success':
      $imgSrc = '../media/flashMessages_img/success-icon.png';
      break;
    case 'info':
      $imgSrc = '../media/flashMessages_img/info-icon.png';
      break;
    case 'error':
      $imgSrc = '../media/flashMessages_img/error-icon.png';
      break;
}
  ?>
  <img src="<?php echo $imgSrc; ?>" alt="Alert Icon" class="alert-icon">
  <span><?php echo isset($msg['text']) ? $msg['text'] : ''; ?></span>
</div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
    function display(ele) {
        let element = document.getElementsByTagName("nav")[0];
        if (element) {
            element.after(ele);
        }
    }

    display(document.getElementById("flash"));
</script>

<style>
.alert-success {
    opacity:0;

    display: flex;
    align-items: center;

    max-width: 20rem;
    max-height: 3rem;
    
    animation-duration: 4s;
    animation-iteration-count: 1;
    animation-name: appear; 
}  

@keyframes appear {

    to{
    opacity:1;
    background-color: transparent;
    
    transform: translateY(75%);
    margin-top: -20px;
    border-radius: 5px;
    border-color: rgb(90, 237, 90);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    color: black;
    padding: 10px 20px;
    }
    
}

.alert-info {
    opacity:0;
    display: flex;
    align-items: center;

    animation-duration: 5s;
    animation-iteration-count: 1;
    animation-name: appear; 
}

.alert-error {
    opacity:0;
    display: flex;
    align-items: center;

    animation-duration: 5s;
    animation-iteration-count: 1;
    animation-name: appear; 
}
.alert-icon {
  margin-right: 30px; /*Adjust the spacing between the image and message */
  height: 2rem;
  width:2rem;
  justify-self: center;
}

</style>