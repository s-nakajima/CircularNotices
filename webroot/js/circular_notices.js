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
         * Initialize
         *
         * @return {void}
         */
        $scope.initCircularNoticeIndex = function(data) {
            $scope.frameId = data.frameId;
            $scope.frameKey = data.frameKey;
            $scope.circularNoticeFrameSetting = data.circularNoticeFrameSetting;
            $scope.circularNotice = data.circularNotice;
            $scope.circularNoticeContentList = data.circularNoticeContentList;
            $scope.selectOption = data.selectOption;
            $scope.reply_deadline_set_flag = '';
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

            // 回答方式の定数を格納
            $scope.circularNoticeContentReplyTypeText = data.circularNoticeContentReplyType.typeText;
            $scope.circularNoticeContentReplyTypeMultipleSelection = data.circularNoticeContentReplyType.typeSelection;
            $scope.circularNoticeContentReplyTypeMultipleSelection = data.circularNoticeContentReplyType.typeMultipleSelection;
        };
    });
