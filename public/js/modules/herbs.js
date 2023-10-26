
const cols = [[
    {type: 'checkbox', fixed: 'left'},
    {field:'common_name', width:200, title: '名称'},
    {field:'scientific_name', width:200, title: '拉丁', sort: true},
    {field:'other_names', width:100, title: '别名', sort: true},
    {field:'medicinal_smell_name', width: 150, title: '味', sort: true},
    {field:'medicine_character_name', width: 100, title: '药性', sort: true},
    {field:'toxicity_name', width: 80, title: '毒性', sort: true},
    {field:'efficacy', width: 300, title: '主治', sort: true},
    {field:'book_name', width: 200, title: '书籍', sort: true},
    {field:'created_at', title:'创建时间', width: 120},
    {fixed: 'right', title:'操作', width: 134, minWidth: 125, toolbar: '#barDemo'}
]];

const dropdown_action = {
    btn:[{
        id: 'add',
        type:1,
        area: ['80%', '80%'],
        content: '<form class="layui-form" action="">\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">药材名</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="username" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">拉丁名称</label>\n' +
            '    <div class="layui-input-inline layui-input-wrap">\n' +
            '      <input type="text" name="vercode" lay-verify="required" autocomplete="off" lay-affix="clear" class="layui-input">\n' +
            '    </div>\n' +
            '  </div>\n' +


            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">单行选择框</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <select name="interest" lay-filter="aihao">\n' +
            '        <option value=""></option>\n' +
            '        <option value="0">写作</option>\n' +
            '        <option value="1" selected>阅读</option>\n' +
            '        <option value="2">游戏</option>\n' +
            '        <option value="3">音乐</option>\n' +
            '        <option value="4">旅行</option>\n' +
            '      </select>\n' +
            '    </div>\n' +
            '  </div>  \n' +

            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">复选框</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="checkbox" name="arr[0]" title="选项1">\n' +
            '      <input type="checkbox" name="arr[1]" title="选项2" checked>\n' +
            '      <input type="checkbox" name="arr[2]" title="选项3">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">标签框</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="checkbox" name="arr1[0]" lay-skin="tag" title="选项1" checked>\n' +
            '      <input type="checkbox" name="arr1[1]" lay-skin="tag" title="选项2">\n' +
            '      <input type="checkbox" name="arr1[2]" lay-skin="tag" title="选项3">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">开关</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="checkbox" name="open" lay-skin="switch" lay-filter="switchTest" title="ON|OFF">\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <label class="layui-form-label">单选框</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="radio" name="sex" value="男" title="男" checked>\n' +
            '      <input type="radio" name="sex" value="女" title="女">\n' +
            '      <input type="radio" name="sex" value="禁" title="禁用" disabled>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item layui-form-text">\n' +
            '    <label class="layui-form-label">普通文本域</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <textarea placeholder="请输入内容" class="layui-textarea"></textarea>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '  <div class="layui-form-item">\n' +
            '    <div class="layui-input-block">\n' +
            '      <button type="submit" class="layui-btn" lay-submit lay-filter="demo1">立即提交</button>\n' +
            '      <button type="reset" class="layui-btn layui-btn-primary">重置</button>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</form>',
        title: '添加药材'
    },{
        id: 'update',
        type:1,
        area: ['80%', '80%'],
        content: '<div style="padding: 16px;">自定义表单元素</div>',
        title: '编辑'
    },{
        id: 'delete',
        type:1,
        area: ['80%', '80%'],
        content: '<div style="padding: 16px;">自定义表单元素</div>',
        title: '删除'
    }],
}


const dropdown_list_action = {
    btn:[{
        id: 'detail',
        type:2,
        area: ['80%', '80%'],
        content: '/admin/herbs/detail',
        title: '详细资料'
    },{
        id: 'detail',
        type:1,
        area: ['80%', '80%'],
        content: '/public/your_html_file.html',
        title: '查1看'
    },{
        id: 'delete',
    }],
}

$.getTableList('/admin/herbs/getHerbsList','#test',cols,dropdown_action,dropdown_list_action)
