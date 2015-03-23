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
NetCommonsApp.controller('CircularNotices.view',
    function($scope, NetCommonsBase, NetCommonsUser) {

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
        $scope.initialize = function(data) {
            $scope.frameId = data.frameId;
            $scope.frameKey = data.frameKey;
            $scope.circularNoticeFrameSetting = data.circularNoticeFrameSetting;
            $scope.circularNotice = data.circularNotice;
            $scope.circularNoticeContentList = data.circularNoticeContentList;
            $scope.selectOption = data.selectOption;
        };
    });

/**
 * CircularNotices.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce)} Controller
 */
NetCommonsApp.controller('CircularNotices.edit',
    function($scope, NetCommonsBase, NetCommonsUser) {

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
        $scope.initialize = function(data) {
            // $scope.frameId = data.frameId;
            // $scope.frameKey = data.frameKey;
            // $scope.circularNoticeFrameSetting = data.circularNoticeFrameSetting;
            // $scope.circularNotice = data.circularNotice;
            // $scope.circularNoticeContentList = data.circularNoticeContentList;
            $scope.replyType = data.replyType;
        };
    });
