<!--Place inside the loop(this uses font awesome icons)-->
<?php
  /*
  ***
  Attention
  ***
  //This must be al coded inside https://codex.wordpress.org/The_Loop
  */
  $post_id = $post->ID;
  //Get current post meta
  $post_puntos = get_post_meta($post_id, 'karma', true);
  if (!$post_puntos) {
    $post_puntos = 0;
  }
?>
<button class="upvote" value="<?=$post_id?>"><i title="Like" alt="Karma up" style="color:green;" class="far fa-arrow-alt-circle-up"></i>up</button>
<button class="downvote" value="<?=$post_id?>"><i title="Dislike" alt="Karma down" style="color:red;" class="far fa-arrow-alt-circle-down"></i>down</button>
<span id="post-karma-<?=$post_id?>"><?=$post_points?></span>
