$.extend({
    getTableList:function(url,element_id,cols,dropdown_action=null,dropdown_list_action=null,table_rowd=null) {
        layui.use(['table', 'dropdown'], function(){
            var table = layui.table;
            var dropdown = layui.dropdown;
            var form = layui.form;
            var laydate = layui.laydate;

            // 创建渲染实例
            table.render({
                elem: element_id,
                url:url,
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'exports', 'print', {
                    title: '提示',
                    layEvent: 'LAYTABLE_TIPS',
                    icon: 'layui-icon-tips'
                }],
                height: 'full-200', // 最大高度减去其他容器已占有的高度差
                css: [ // 重设当前表格样式
                    '.layui-table-tool-temp{padding-right: 145px;}'
                ].join(''),
                cellMinWidth: 80,
                // totalRow: true, // 开启合计行
                page: true,
                cols:cols,
                done: function(){
                    var id = this.id;
                    // 下拉按钮测试
                    dropdown.render({
                        elem: '#dropdownButton', // Change this to your desired element
                        data: dropdown_action.btn,
                        click: function (obj) {
                            var checkStatus = table.checkStatus(id);
                            var data = checkStatus.data;

                            switch (obj.id) {
                                case 'add':
                                    const action = dropdown_action.btn.find(item => item.id === obj.id);
                                    if (!action) return;
                                    layer.open({
                                        title: action.title,
                                        type: action.type,
                                        area: action.area,
                                        content: action.content,
                                        });
                                      form.render();
                                    break;
                                case 'update':
                                    if (data.length !== 1) return layer.msg('请选择一行');
                                    layer.open({
                                        title: '编辑',
                                        type: 1,
                                        area: ['80%', '80%'],
                                        content: '<div style="padding: 16px;">自定义表单元素</div>'
                                    });
                                    break;
                                case 'delete':
                                    if (data.length === 0) {
                                        return layer.msg('请选择一行');
                                    }
                                    layer.msg('delete event');
                                    break;
                            }
                            form.render();
                        }
                    });
                    // 行模式
                    dropdown.render({
                        elem: '#rowMode',
                        data: [{
                            id: 'default-row',
                            title: '单行模式（默认）'
                        },{
                            id: 'multi-row',
                            title: '多行模式'
                        }],
                        // 菜单被点击的事件
                        click: function(obj){
                            var checkStatus = table.checkStatus(id)
                            var data = checkStatus.data; // 获取选中的数据
                            switch(obj.id){
                                case 'default-row':
                                    table.reload('test', {
                                        lineStyle: null // 恢复单行
                                    });
                                    layer.msg('已设为单行');
                                    break;
                                case 'multi-row':
                                    table.reload('test', {
                                        // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
                                        lineStyle: 'height: 95px;'
                                    });
                                    layer.msg('即通过设置 lineStyle 参数可开启多行');
                                    break;
                            }
                        }
                    });
                },
                error: function(res, msg){
                    console.log(res, msg)
                }
            });

            // 工具栏事件
            table.on('toolbar(test)', function(obj){
                var id = obj.config.id;
                var checkStatus = table.checkStatus(id);
                var othis = lay(this);
                switch(obj.event){
                    case 'getCheckData':
                        var data = checkStatus.data;
                        layer.alert(layui.util.escape(JSON.stringify(data)));
                        break;
                    case 'getData':
                        var getData = table.getData(id);
                        console.log(getData);
                        layer.alert(layui.util.escape(JSON.stringify(getData)));
                        break;
                    case 'LAYTABLE_TIPS':
                        layer.alert('自定义工具栏图标按钮');
                        break;
                };
            });
            // 表头自定义元素工具事件 --- 2.8.8+
            table.on('colTool(test)', function(obj){
                var event = obj.event;
                console.log(obj);
                if(event === 'email-tips'){
                    layer.alert(layui.util.escape(JSON.stringify(obj.col)), {
                        title: '当前列属性配置项'
                    });
                }
            });

            // 触发单元格工具事件
            table.on('tool(test)', function(obj){ // 双击 toolDouble
                var data = obj.data; // 获得当前行数据
                // console.log(obj)
                if(obj.event === 'edit'){
                    layer.open({
                        title: '编辑 - id:'+ data.Cell_ID,
                        type: 1,
                        area: ['80%','80%'],
                        content: '<div style="padding: 16px;">自定义表单元11素</div>'
                    });
                } else if(obj.event === 'more'){
                    // 更多 - 下拉菜单
                    dropdown.render({
                        elem: this, // 触发事件的 DOM 对象
                        show: true, // 外部事件触发即显示
                        data:dropdown_list_action.btn,
                        click: function(obj){
                            switch (obj.id) {
                                case 'detail':
                                    const action = dropdown_list_action.btn.find(item => item.id === obj.id);
                                    if (!action) return;
                                    layer.open({
                                        title: action.title,
                                        type: action.type,
                                        area: action.area,
                                        content: action.content+"?id="+data.id,
                                    });
                                    form.render();
                                    break;
                                case 'update':
                                    if (data.length !== 1) return layer.msg('请选择一行');
                                    layer.open({
                                        title: '编辑',
                                        type: 1,
                                        area: ['80%', '80%'],
                                        content: '<div style="padding: 16px;">自定义表单元素</div>'
                                    });
                                    break;
                                case 'delete':
                                    if (data.length === 0) {
                                        return layer.msg('请选择一行');
                                    }
                                    layer.msg('delete event');
                                    break;
                            }
                            form.render();
                        },
                        align: 'right', // 右对齐弹出
                        style: 'box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' // 设置额外样式
                    })
                }
            });

            // 触发表格复选框选择
            table.on('checkbox(test)', function(obj){
                console.log(obj)
            });

            // 触发表格单选框选择
            table.on('radio(test)', function(obj){
                console.log(obj)
            });

            // 行单击事件
            table.on('row(test)', function(obj){
                //console.log(obj);
                //layer.closeAll('tips');
            });
            // 行双击事件
            table.on('rowDouble(test)', function(obj){
                console.log(obj);
            });

            // 单元格编辑事件
            table.on('edit(test)', function(obj){
                var field = obj.field; // 得到字段
                var value = obj.value; // 得到修改后的值
                var data = obj.data; // 得到所在行所有键值
                // 值的校验
                if(field === 'email'){
                    if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(obj.value)){
                        layer.tips('输入的邮箱格式不正确，请重新编辑', this, {tips: 1});
                        return obj.reedit(); // 重新编辑 -- v2.8.0 新增
                    }
                }
                // 编辑后续操作，如提交更新请求，以完成真实的数据更新
                // …
                layer.msg('编辑成功', {icon: 1});

                // 其他更新操作
                var update = {};
                update[field] = value;
                obj.update(update);
            });
            // 日期
            laydate.render({
                elem: '.demo-table-search-date'
            });
            // 搜索提交
            form.on('submit(demo-table-search)', function(data){
                var field = data.field; // 获得表单字段
                // 执行搜索重载
                table.reload('test', {
                    page: {
                        curr: 1 // 重新从第 1 页开始
                    },
                    where: field // 搜索的字段
                });
                // layer.msg('搜索成功<br>此处为静态模拟数据，实际使用时换成真实接口即可');
                return false; // 阻止默认 form 跳转
            });
        });
    }
})