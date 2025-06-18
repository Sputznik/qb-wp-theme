<?php
$post_id = get_the_ID();

$contributor_roles = array(
  'author'       => 'Author',
  'editor'       => 'Editor',
  'illustrator'  => 'Illustrator',
  'photographer' => 'Photographer',
  'producer'     => 'Producer'
);

$grouped_contributors = [];

foreach ( $contributor_roles as $role_key => $role_label ) {
  $user_ids_raw = get_post_meta( $post_id, $role_key, true );
  if ( ! empty( $user_ids_raw ) ) {
    $user_ids = array_unique( array_map( 'trim', explode( ',', $user_ids_raw ) ) );
    foreach ( $user_ids as $user_id ) {
      $user = get_userdata( $user_id );
      if ( $user ) {
        $grouped_contributors[$role_label][] = [
          'name' => $user->display_name,
          'url'  => get_author_posts_url( $user->ID )
        ];
      }
    }
  }
}
?>

<?php if ( ! empty( $grouped_contributors ) ) : ?>
  <div class="contributors-container">
    <div class="contributors-inner">
      <div class="contributor">
        <strong>Contributors</strong>
      </div>
      <?php foreach ( $grouped_contributors as $role => $users ) : ?>
        <div class="contributor">
          <div class="contributor-names">
            <?php
            $names = [];
            foreach ( $users as $user ) {
              $names[] = '<a rel="author" href="' . esc_url( $user['url'] ) . '">' . esc_html( $user['name'] ) . '</a>';
            }
            echo implode( ',&nbsp;&nbsp;', $names );
            ?>
          </div>
          
          <?php
            $role_count = count( $users );
            $role_label = $role;
            if ( $role_count > 1 ) {
                $role_label .= 's';
            }
            ?>
            <div class="contributor-role"><?php echo esc_html( $role_label ); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
