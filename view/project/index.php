<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AmbitRootss AI - 漏洞管理台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* 侧边栏与代码块自定义美化 */
        body { background-color: #f4f6f9; }
        .sidebar-menu .list-group-item { border: none; padding: 12px 20px; border-radius: 8px; margin-bottom: 4px; font-weight: 500; color: #495057; }
        .sidebar-menu .list-group-item:hover { background-color: #e9ecef; }
        .sidebar-menu .list-group-item.active { background-color: #0d6efd; color: white; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2); }
        .code-bg { background-color: #f8f9fa; border: 1px solid #e9ecef; color: #d63384; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-shield-check text-primary me-2 fs-4 align-middle"></i>
            <span class="align-middle">AmbitRootss AI</span>
        </a>
        <div class="text-white-50 small">Vulnerability Management & Code Auditing</div>
    </div>
</nav>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-2 mb-4">
            <div class="list-group sidebar-menu bg-white p-2 shadow-sm rounded-3">
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-grid-1x2 fs-5 me-3 text-secondary"></i> 仪表盘概要
                </a>
                <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center" aria-current="true">
                    <i class="bi bi-folder2-open fs-5 me-3"></i> 项目列表
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-github fs-5 me-3 text-secondary"></i> 仓库列表
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-braces-asterisk fs-5 me-3 text-secondary"></i> Code QL 分析
                </a>
            </div>
        </div>

        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm rounded-3">
                <h4 class="m-0 fw-bold text-dark">
                    <i class="bi bi-list-task me-2 text-primary"></i>项目管理
                </h4>
                <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-plus-circle me-2"></i> 添加项目
                </button>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-light border-bottom-0">
                            <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">
                                <i class="bi bi-database-add me-2 text-primary"></i>录入新项目
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{:url('project/_add')}">
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary">项目名称</label>
                                    <input type="text" class="form-control form-control-lg bg-light" name="name" placeholder="例如：某开源 CMS 系统" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-secondary">Git 仓库地址</label>
                                    <textarea class="form-control bg-light" name="git_addrs" rows="4" placeholder="支持多行批量输入，每行一个完整地址..." required></textarea>
                                </div>
                                <div class="form-text text-muted small"><i class="bi bi-info-circle me-1"></i>系统将自动抓取该地址进行代码审计。</div>
                            </div>
                            <div class="modal-footer border-top-0 bg-light">
                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary px-4">确认提交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0 bg-white">
                        <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 fw-semibold border-bottom-0">ID</th>
                            <th class="py-3 fw-semibold border-bottom-0">项目名称</th>
                            <th class="py-3 fw-semibold border-bottom-0">项目地址 (Git URL)</th>
                            <th class="py-3 fw-semibold border-bottom-0">创建时间</th>
                            <th class="text-end pe-4 py-3 fw-semibold border-bottom-0">操作面板</th>
                        </tr>
                        </thead>
                        <tbody class="border-top-0">
                        {volist name="list" id="vo" empty="<tr><td colspan='5' class='text-center py-5 text-muted'><i class='bi bi-inbox fs-1 d-block mb-2'></i>暂无项目数据，请点击上方按钮添加。</td></tr>"}
                        <tr>
                            <td class="ps-4 text-secondary fw-medium">#{$vo.id}</td>
                            <td class="fw-bold text-dark">{$vo.name}</td>
                            <td><code class="code-bg px-2 py-1 rounded shadow-sm fs-6">{$vo.addr}</code></td>
                            <td class="text-secondary small">
                                <i class="bi bi-clock me-1"></i>{$vo.create_time|default='未知时间'}
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border text-primary rounded-pill px-3 fw-medium">
                                    <i class="bi bi-search me-1"></i>审计详情
                                </a>
                                <a href="{:url('project/_del', ['id'=>$vo.id])}"
                                   class="btn btn-sm btn-light border text-danger rounded-pill px-3 fw-medium ms-1"
                                   onclick="return confirm('警告：确定要永久删除该项目及其扫描记录吗？')">
                                    <i class="bi bi-trash3 me-1"></i>删除
                                </a>
                            </td>
                        </tr>
                        {/volist}
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>