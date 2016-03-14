<?php
/**
 * circular notice edit choices element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Hirohisa Kuwata <Kuwata.Hirohisa@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
	$this->Html->script(
		'/circular_notices/js/choices.js',
		array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		)
	);
?>

<?php $this->Form->unlockField('CircularNoticeChoices'); ?>

<div class="panel panel-default" ng-controller="CircularNoticeChoices" ng-init="initialize(<?php echo h(json_encode(['choices' => $circularNoticeChoice])); ?>)">

	<div class="panel-body">
		<div class="form-group text-right">
			<button type="button" class="btn btn-success btn-sm" ng-click="add()">
				<span class="glyphicon glyphicon-plus"> </span>
			</button>
		</div>

		<div ng-hide="choices.length">
			<p><?php echo h(__d('circular_notices', 'No choices')); ?></p>
		</div>

		<div class="pre-scrollable" ng-show="choices.length">
			<article class="form-group" ng-repeat="c in choices track by $index">
				<div class="input-group input-group-sm">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default"
								ng-click="move('up', $index)" ng-disabled="$first">
							<span class="glyphicon glyphicon-arrow-up"></span>
						</button>
						<button type="button" class="btn btn-default"
								ng-click="move('down', $index)" ng-disabled="$last">
							<span class="glyphicon glyphicon-arrow-down"></span>
						</button>
					</div>

					<input type="hidden" name="data[CircularNoticeChoices][{{$index}}][CircularNoticeChoice][id]" ng-value="c.id">
					<input type="hidden" name="data[CircularNoticeChoices][{{$index}}][CircularNoticeChoice][weight]" ng-value="{{$index + 1}}">
					<input type="text" name="data[CircularNoticeChoices][{{$index}}][CircularNoticeChoice][value]" ng-model="c.value" class="form-control" required autofocus>

					<div class="input-group-btn">
						<button type="button" class="btn btn-default" tooltip="<?php echo h(__d('net_commons', 'Delete')); ?>"
								ng-click="delete($index)">
							<span class="glyphicon glyphicon-remove"> </span>
						</button>
					</div>
				</div>
			</article>
			<div class="has-error">
				<?php echo $this->NetCommonsForm->error('CircularNoticeChoice.value', null, array('class' => 'help-block')); ?>
			</div>
		</div>
	</div>
</div>
