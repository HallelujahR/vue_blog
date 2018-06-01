<!-- Modal -->
<div class="modal fade" id="Release" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div>
                    <span id="fb">发布</span>
                    <a href="#" @click="test">文章</a>
                    <span>/</span>
                    <a href="#" @click="test1">问题</a>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <transition name="component-fade" mode="out-in">
                        <Release v-if="show"></Release>
                        <Question v-else></Question>
                    </transition>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
