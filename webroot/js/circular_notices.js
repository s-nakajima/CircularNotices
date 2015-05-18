/**
 * @fileoverview CircularNotices Javascript
 * @author Kuwata.Hirohisa@withone.co.jp (Hirohisa Kuwata)
 */


/**
 * CircularNotices.view Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce)} Controller
 */
NetCommonsApp.controller('CircularNotices',
    function($scope, NetCommonsBase, NetCommonsWysiwyg, NetCommonsTab, NetCommonsUser, NetCommonsWorkflow) {

        /**
         * show user information method
         *
         * @param {number} users.id
         * @return {string}
         */
        $scope.user = NetCommonsUser.new();

        /**
         * serverValidationClear method
         *
         * @param {number} users.id
         * @return {string}
         */
        $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

        /**
         * tinymce
         *
         * @type {object}
         */
        $scope.tinymce = NetCommonsWysiwyg.new();

        /**
         * form
         *
         * @type {form}
         */
        // $scope.form = {};

        /**
         * master
         *
         * @type {object}
         */
        // $scope.master = {};

        /**
         * Initialize for Index
         *
         * @return {void}
         */
        $scope.initCircularNoticeIndex = function(data) {
            $scope.displayOrder = data.displayOrder;
            $scope.currentPage = data.currentPage;
            $scope.visibleRowCount = data.visibleRowCount;
            $scope.narrowDownParams = data.narrowDownParams;
        };

        /**
         * Initialize for View
         *
         * @return {void}
         */
        $scope.initCircularNoticeView = function(answer, choices) {
            $scope.answer = answer;
            $scope.showReplyForm = false;
            $scope.showOtherUsers = false;
        };

        /**
         * Switch Reply Form
         *
         * @return {void}
         */
        $scope.switchReplyForm = function(data) {
            $scope.showReplyForm = data;
        };

        /**
         * Switch Other User's Answer View
         *
         * @return {void}
         */
        $scope.switchOtherUserView = function(data) {
            $scope.showOtherUsers = data;
        };

        /**
         * Initialize for Edit View
         *
         * @return {void}
         */
        $scope.initCircularNoticeEdit = function(data) {
            // 回覧内容を格納
            $scope.circularNoticeContentContent = data.content;

            // 回答方式を格納
            $scope.circularNoticeContentReplyType = data.replyType;
        };
    });
