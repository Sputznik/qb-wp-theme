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
          'url'  => get_author_posts_url( $user->ID ),
          'bio'  => get_the_author_meta( 'description', $user->ID ),
        ];
      }
    }
  }
}
?>

<?php if ( ! empty( $grouped_contributors ) ) : ?>
  <div class="credits-container">
    <h3 >Credits</h3>

    <?php foreach ( $grouped_contributors as $role => $users ) : ?>
      <?php
        $role_count = count( $users );
        $role_label = $role_count > 1 ? rtrim( $role, 'r' ) . 'rs' : $role;
      ?>
      
      <!-- Role -->
      <div style="font-weight: bold; font-family: Lora; margin-bottom: 0.75rem;">
        <?php echo esc_html( $role_label ); ?>
      </div>

      <!-- Users -->
      <?php foreach ( $users as $user ) : ?>
        <div style="margin-bottom: 1rem;">
          <?php if ( ! empty( $user['name'] ) && ! empty( $user['url'] ) ) : ?>
            <div>
              <a rel="author" href="<?php echo esc_url( $user['url'] ); ?>" style="text-decoration: none; text-transform: capitalize;">
                <?php echo esc_html( $user['name'] ); ?>
              </a>
              <?php if ( ! empty( $user['bio'] ) ) : ?>
                : <?php echo esc_html( $user['bio'] ); ?>
          <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <!-- Spacer between roles -->
      <div style="margin-bottom: 2rem;"></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
