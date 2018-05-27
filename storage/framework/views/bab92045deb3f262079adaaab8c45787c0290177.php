<!-- Modal -->
<div class="modal fade" id="Release" tabindex="-1" style="display:block;opacity:1;z-index:1000" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">发布</h4>
      </div>
      <div class="modal-body">
            <div class="panel-body">
                <Release></Release>
            </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    import Release from './components/Release.vue'
    new Vue({
        el:'#Release',
    })
</script>
<?php $__env->stopSection(); ?>
