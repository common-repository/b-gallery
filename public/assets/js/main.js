jQuery(document).ready(function ($) {
  "use strict";

  const initializeLightBox = () => {
    $(".gallery").flashy({
      prevShowClass: "fx-bounceInLeft",
      nextShowClass: "fx-bounceInRight",
      prevHideClass: "fx-bounceOutRight",
      nextHideClass: "fx-bounceOutLeft",
    });

    $(".vGallery").flashy({
      // Applied when a new item is shown
      showClass: "fx-fadeIn",
      // show title
      title: true,
      // Applied when a new item is hidden
      hideClass: "fx-fadeOut",

      // Applied when a new item is shown on prev event
      prevShowClass: "fx-bounceInLeft",

      // Applied when a new item is shown on next event
      nextShowClass: "fx-bounceInRight",

      // Applied when the current item is hidden on prev event
      prevHideClass: "fx-bounceOutRight",

      // Applied when the current item is hidden on next event
      nextHideClass: "fx-bounceOutLeft",
      // enable/Disable video autoplay
      videoAutoPlay: true,
    });
  };
  initializeLightBox();

  // Declare Variable for Ajax LoadMore
  const id = $(".bGallery").data("id");
  let limit = $(".bGallery").data("limit");
  let load = $(".bGallery").data("load");
  console.log({id, limit, load});
  // LoadMore Button for Ajax load
   
  $("#bGal_moreMore").on("click", function () {
    const button = $(this);
    let page = 0;
    $(".loadingMain").show();
    $.ajax({
      // use the ajax object url
      url: ajax_obj.ajax_url,

      data: {
        action: "load_more_post_ajax", // add your action to the data object
        id,
        offset: limit,
        nonce: ajax_obj.nonce,
      },
      success: function (data) {
        data = JSON.parse(data);
        $(".bGallery").append(data?.content);
        limit += load;
        initializeLightBox();
        $(".loadingMain").hide();
        if (!data?.item) {
          button.slideDown(5000).fadeOut();
        }
      },
      error: function (data) {
        // test to see what you get back on error
        console.log(data);console.log("Error");
      }
       
    });
  });
  
});
