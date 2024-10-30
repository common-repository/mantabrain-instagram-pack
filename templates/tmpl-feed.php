<?php
defined('ABSPATH') || exit;
/*
 * var $feed_data
 */
?>

<div class="mb-instagram-pack-profile-feed">
    <header>
        <div class="ip-container">

            <div class="profile">

                <div class="profile-image">

                    <a href="https://www.instagram.com/<?php echo esc_attr($user_data['username']) ?>"
                       target="_blank"><img src="<?php echo esc_html($user_data['profile_picture']) ?>"
                                            alt=""></a>

                </div>

                <a href="https://www.instagram.com/accounts/edit/" target="_blank">
                    <div class="profile-user-settings">

                        <h1 class="profile-user-name"><?php echo esc_html($user_data['username']); ?></h1>

                        <button class="btn profile-edit-btn">Edit Profile</button>

                        <button class="btn profile-settings-btn" aria-label="profile settings"><i class="fa fa-cog"
                                                                                                  aria-hidden="true"></i>
                        </button>

                    </div>
                </a>

                <?php $counts = isset($user_data['counts']) ? $user_data['counts'] : array() ?>
                <div class="profile-stats">

                    <ul>
                        <li class="total-posts-count" data-post-count="<?php echo absint($counts['media']) ?>">
                            <span class="profile-stat-count"><?php echo isset($counts['media']) ? absint($counts['media']) : 0; ?></span>
                            posts
                        </li>
                        <li>
                            <span class="profile-stat-count"><?php echo isset($counts['followed_by']) ? absint($counts['followed_by']) : 0; ?></span>
                            followers
                        </li>
                        <li>
                            <span class="profile-stat-count"><?php echo isset($counts['follows']) ? absint($counts['follows']) : 0; ?></span>
                            following
                        </li>
                    </ul>

                </div>

                <div class="profile-bio">

                    <p>
                        <span class="profile-real-name"><?php echo esc_html($user_data['full_name']); ?></span> <?php echo isset($user_data['bio']) ? esc_html($user_data['bio']) : ''; ?>
                    </p>
                    <?php if (isset($user_data['website'])) { ?>
                        <p><a href="<?php echo esc_attr($user_data['website']) ?>"
                              target="_blank"><?php echo esc_html($user_data['website']) ?></a></p>
                    <?php } ?>
                </div>

            </div>
            <!-- End of profile section -->

        </div>
        <!-- End of ip-container -->

    </header>

    <main>

        <div class="ip-container">
            <?php $grid_number = mb_instagram_pack_get_option('instagram_pack_feed_grid', 3); ?>

            <div class="ip-gallery <?php echo 'gallery-grid-' . absint($grid_number) ?>">

                <?php
                $last_id = '';

                foreach ($feed_data as $data) {

                    include "tmpl-feed-item.php";

                    $last_id = $data['id'];
                }
                ?>

            </div>
            <!-- End of gallery -->

            <?php
            $load_more_text = mb_instagram_pack_get_option('load_more_text', __('Load more..', 'mb-instagram-pack'));
            $loading_text = mb_instagram_pack_get_option('load_more_loading_text', __('Loading..', 'mb-instagram-pack'));
            $follow_text = mb_instagram_pack_get_option('follow_text', __('Follow', 'mb-instagram-pack'));
            ?>
            <div class="footer-btn">
                <a class="load-more" data-loading-text="<?php echo esc_attr($loading_text); ?>"
                   data-text="<?php echo esc_attr($load_more_text); ?>"
                   data-last-id="<?php echo esc_attr($last_id); ?>"><?php echo esc_html($load_more_text); ?></a>
                <a class="follow" href="https://www.instagram.com/<?php echo esc_attr($user_data['username']) ?>"
                   target="_blank"><i
                            class="fa fa-instagram"></i> <?php echo esc_attr($follow_text); ?></a>
            </div>

        </div>
        <!-- End of ip-container -->

    </main>

</div>