// @var mb_instagram_pack_params
var InstagramPackFrontend = function ($) {
    return {

        init: function () {
            this.cacheDom();
            this.bindEvents();
        },
        cacheDom: function () {
            this.$load_more_btn = $('.mb-instagram-pack-profile-feed .load-more');
        },

        bindEvents: function () {
            var $this = this;
            this.$load_more_btn.on('click', function (e) {
                e.preventDefault();
                var last_post_id = $(this).closest('.ip-container').find('.ip-gallery').find('.ip-gallery-item:last-child').attr('data-post-id');
                if (last_post_id == '') {
                    return;
                }
                $this.loadMore(last_post_id, $(this));
            });
        },
        addLoading: function ($node) {

            var type = $node[0].tagName.toLowerCase();

            if (type === "a") {
                $node.text($node.attr('data-loading-text'));
            } else {
                $node.val($node.attr('data-loading-text'));
            }

        }, removeLoading: function ($node) {
            var type = $node[0].tagName.toLowerCase();
            if (type === "a") {
                $node.text($node.attr('data-text'));
            } else {
                $node.val($node.attr('data-text'));
            }
        },
        loadMore: function (last_post_id, $load_more) {
            var $this = this;
            var load_more_profile_params = mb_instagram_pack_params.load_more_profile_params;
            var load_more_profile_data = {
                action: load_more_profile_params.load_more_profile_action,
                mb_instagram_pack_nonce: load_more_profile_params.load_more_profile_nonce,
                last_post_id: last_post_id
            };
            $.ajax({
                type: "POST",
                url: mb_instagram_pack_params.ajax_url,
                data: load_more_profile_data,
                beforeSend: function () {
                    $this.addLoading($load_more);
                },
                success: function (data) {

                    $load_more.closest('.ip-container').find('.ip-gallery').append(data);

                    var total_data_count = $load_more.closest('.mb-instagram-pack-profile-feed').find('.total-posts-count').attr('data-post-count');

                    var total_loaded_data = $load_more.closest('.ip-container').find('.ip-gallery .ip-gallery-item').length;

                    if (total_data_count == total_loaded_data) {

                        $load_more.hide();
                    }

                },
                complete: function () {
                    $this.removeLoading($load_more);
                }
            });
        }

    };
}(jQuery);


(function ($) {

    $(document).ready(function () {

        InstagramPackFrontend.init();
    });
}(jQuery));