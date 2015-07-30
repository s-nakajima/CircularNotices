/**
 * @fileoverview CircularNotices Javascript
 * @author Kuwata.Hirohisa@withone.co.jp (Hirohisa Kuwata)
 */


/**
 * CircularNotices.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('CircularNoticeEdit',
    function($scope, NetCommonsWysiwyg) {

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      /**
       * CircularNoticeContent object
       *
       * @type {object}
       */
      $scope.circularNoticeContent = [];

      /**
       * Initialize
       *
       * @param {object} CircularNoticeContents data
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.circularNoticeContent = data;
      };

    });


/**
 * CircularNotices.view Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('CircularNoticeView', function($scope) {

  /**
   * Initialize
   *
   * @return {void}
   */
  $scope.initialize = function() {
    $scope.showReplyForm = false;
    $scope.showOtherUsers = true;
  };

  /**
   * Switch reply form
   *
   * @param {boolean} Flag of visibility
   * @return {void}
   */
  $scope.switchReplyForm = function(isVisible) {
    $scope.showReplyForm = isVisible;
  };

  /**
   * Switch other user's list
   *
   * @param {boolean} Flag of visibility
   * @return {void}
   */
  $scope.switchOtherUserView = function(isVisible) {
    $scope.showOtherUsers = isVisible;
  };

});
