<?php


class GoForth {

  public static function go_forth_summary( $atts = array(), $content = null, $tag = '' ) {
    $sticky_posts = self::summary_sticky_posts();
    $non_sticky_posts = self::summary_non_sticky_posts();
    return self::render_summary($sticky_posts, $non_sticky_posts);
  }
  
  public static function render_summary($sticky, $non_sticky) {
    $summary = [];
    $output = <<<HTML
      <div class="go-forth__summary">
    HTML;

    for ($i = 0; $i <= 7; $i++) {
      if (self::total($sticky, $non_sticky) > 0) {
        $post = count($sticky) > 0 ? array_shift($sticky) : array_shift($non_sticky);
        if (isset($post)) {
          array_push($summary, $post);
        }
      }
    }

    foreach($summary as $index => $post) {
      if (isset($post)) {
        $tag_output = '';
        $thumbnail = $post['thumbnail'];
        $title = $post['title'];
        if (strlen($title) > 30 && $index > 3) {
          $title = substr($title, 0, 30) . "...";
        }
        $tag = $post['categories'][0];
        $body = substr($post['content'], 0, 100) . "...";
        $created = $post['created'];
        if (isset($tag) && $tag !== 'Uncategorized') {
          $tag_output = <<<HTML
            <div class="go-forth__summary__tag" style="z-index: 2;position:absolute; top:40px; padding: 10px 40px; background-color: #31AC6C; color: white;">$tag</div>
          HTML;
        }
        if ($index == 0) {
          $output .= <<<HTML
            <div class="go-forth__summary--first" style="background-image: url('$thumbnail');background-position: center; background-size: cover;">
              $tag_output
              <div class="go-forth__summary--first__title">
                <h5>$created</h5>
                <h3 style="">$title</h3>
                <p style="font-weight:300">$body</p>
              </div>
            </div>   
          HTML;
        } elseif (in_array($index, [1,2,3])) {
          $output .= <<<HTML
            <div class="go-forth__summary--next">
              $tag_output
              <div class="image" style="background-image: url('$thumbnail');background-position: center; background-size: cover;"/></div>
              <div class="go-forth__summary--next__title">
                <h5>$created</h5>
                <h3>$title</h3>
              </div>
            </div>
          HTML;
        } else {
          $output .= <<<HTML
            <div class="go-forth__summary--last">
              <div class="image" style="background-image: url('$thumbnail');background-position: center; background-size: cover;"></div>
              <div class="go-forth__summary--last__title">
                <h5>$created</h5>
                <h3>$title</h3>
              </div>
            </div>
          HTML;
        }
      }
    }
    $output .= <<<HTML
      </div>
    HTML;

    return $output;

  }

  function meks_time_ago() {
    return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'ago' );
  }


  private static function total($sticky, $non_sticky) {
    return count($sticky) + count($non_sticky);
  }

  public static function summary_sticky_posts() {
    $sticky = get_option( 'sticky_posts' );
    $args = array(
      'posts_per_page' => count($sticky),
      'post__in' => $sticky,
      'ignore_sticky_posts' => 1
    );
    return self::summary_posts($args);
  }

  public static function summary_non_sticky_posts() {
    $sticky = get_option( 'sticky_posts' );
    $args =  array(
      'posts_per_page' => (7 - count($sticky)),
      'post__not_in' => $sticky,
    );
    return self::summary_posts($args);  
  }

  private static function summary_posts($args) {
    $query = new WP_Query( $args );
    $original_posts = $query->posts;
    $new_posts = array_map(['self', 'map_post'], $original_posts);
    return $new_posts;
  }

  private static function map_post($post) {
    $categories = self::map_categories($post);
    $thumbnail = get_the_post_thumbnail_url($post);

    if ($thumbnail == '') {
      $thumbnail = 'default.png';
    }
    return array(
      'id' => $post->ID,
      'categories' => $categories,
      'title' => $post->post_title,
      'created' => human_time_diff(get_post_time('U', false, $post)) . ' ago',
      'status' => $post->post_status,
      'mime' => $post->post_mime_type,
      'content' => $post->post_content,
      'thumbnail' => $thumbnail
    );
  }

  private static function map_categories($post) {
    $categories = get_the_category($post->ID);
    $category_names = array_map(function($category) {
      return $category->name;
    }, $categories);
    return $category_names;
  }
}

?>