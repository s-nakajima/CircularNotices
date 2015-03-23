/**
 * @fileoverview CircularNotices Javascript
 * @author Kuwata.Hirohisa@withone.co.jp (Hirohisa Kuwata)
 */


/**
 * CircularNotices Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $sce)} Controller
 */
NetCommonsApp.controller('CircularNotices',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
             NetCommonsTab, NetCommonsUser, NetCommonsWorkflow) {

        /**
         * tab
         *
         * @type {object}
         */
        $scope.tab = NetCommonsTab.new();

        /**
         * show user information method
         *
         * @param {number} users.id
         * @return {string}
         */
        $scope.user = NetCommonsUser.new();

        /**
         * tinymce
         *
         * @type {object}
         */
        $scope.tinymce = NetCommonsWysiwyg.new();

        /**
         * workflow
         *
         * @type {object}
         */
        $scope.workflow = NetCommonsWorkflow.new($scope);

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
            alert('HERE');
            $scope.frameId = data.frameId;
            $scope.frameKey = data.frameKey;
            $scope.circularNoticeFrameSetting = data.circularNoticeFrameSetting;
            $scope.circularNotice = data.circularNotice;
            $scope.circularNoticeContentList = data.circularNoticeContentList;
            $scope.selectOption = data.selectOption;
        };

        /**
         * dialog save
         *
         * @param {number} status
         * - 1: Publish
         * - 2: Approve
         * - 3: Draft
         * - 4: Disapprove
         * @return {void}
         */
        $scope.save = function(status) {
            console.debug(2);
            // $scope.master = angular.copy($scope.announcement);
            // $scope.announcement.status = status;
            // $scope.workflow.editStatus = status;
            // $scope.comment = $scope.workflow.input.comment;
            // console.debug($scope.announcement.status);

            // NetCommonsBase.save(
            //     $scope,
            //     $scope.form,
            //     $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            //     $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            //     $scope.edit,
            //     function(data) {
            //       angular.copy(data.results.announcement, $scope.announcement);
            //     });
            // NetCommonsBase.post(
            //   $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            //   $scope.edit
            // );
        };

        // $scope.reset = function() {
        //   $scope.user = angular.copy($scope.master);
        // };

        // $scope.reset();
    });
