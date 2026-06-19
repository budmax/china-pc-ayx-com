<?php

$siteMeta = [
    'base_url' => 'https://china-pc-ayx.com',
    'site_name' => 'AYX 资讯站',
    'locale' => 'zh_CN',
    'default_author' => 'AYX 编辑',
    'keywords' => ['ayx', 'ayx 资讯', 'ayx 站点', 'pc 版 ayx'],
    'description' => '提供 ayx 平台最新动态与使用指南的站点',
    'nav_items' => [
        ['title' => '首页', 'path' => '/'],
        ['title' => '关于 ayx', 'path' => '/about'],
        ['title' => '帮助中心', 'path' => '/help'],
    ],
    'social' => [
        'weibo' => 'https://weibo.com/ayx_official',
        'wechat' => 'ayx_service',
    ],
];

function generateShortDescription(array $meta, string $separator = ' — '): string
{
    $parts = [];

    if (!empty($meta['site_name'])) {
        $parts[] = $meta['site_name'];
    }

    if (!empty($meta['description'])) {
        $parts[] = $meta['description'];
    }

    if (!empty($meta['keywords'])) {
        $kwStr = implode(', ', $meta['keywords']);
        $parts[] = '关键词：' . $kwStr;
    }

    if (!empty($meta['base_url'])) {
        $parts[] = $meta['base_url'];
    }

    return implode($separator, $parts);
}

function renderMetaTags(array $meta): string
{
    $html = '';

    if (!empty($meta['base_url'])) {
        $escaped = htmlspecialchars($meta['base_url'], ENT_QUOTES, 'UTF-8');
        $html .= '<meta property="og:url" content="' . $escaped . '" />' . "\n";
    }

    if (!empty($meta['site_name'])) {
        $escaped = htmlspecialchars($meta['site_name'], ENT_QUOTES, 'UTF-8');
        $html .= '<meta property="og:site_name" content="' . $escaped . '" />' . "\n";
    }

    if (!empty($meta['description'])) {
        $escaped = htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8');
        $html .= '<meta name="description" content="' . $escaped . '" />' . "\n";
    }

    if (!empty($meta['keywords'])) {
        $kwStr = htmlspecialchars(implode(', ', $meta['keywords']), ENT_QUOTES, 'UTF-8');
        $html .= '<meta name="keywords" content="' . $kwStr . '" />' . "\n";
    }

    return $html;
}

function getAyxCanonicalLink(array $meta): string
{
    if (!empty($meta['base_url'])) {
        $url = rtrim($meta['base_url'], '/') . '/';
        $escaped = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        return '<link rel="canonical" href="' . $escaped . '" />';
    }
    return '';
}

$descriptionText = generateShortDescription($siteMeta);
$metaTagsHtml = renderMetaTags($siteMeta);
$canonicalLink = getAyxCanonicalLink($siteMeta);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($siteMeta['site_name'] ?? 'AYX', ENT_QUOTES, 'UTF-8') ?></title>
    <?= $metaTagsHtml ?>
    <?= $canonicalLink ?>
</head>
<body>
    <h1>欢迎访问 <?= htmlspecialchars($siteMeta['site_name'] ?? 'AYX', ENT_QUOTES, 'UTF-8') ?></h1>
    <p>简短描述：<?= htmlspecialchars($descriptionText, ENT_QUOTES, 'UTF-8') ?></p>
    <p>我们的网址：<a href="<?= htmlspecialchars($siteMeta['base_url'] ?? '#', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($siteMeta['base_url'] ?? '', ENT_QUOTES, 'UTF-8') ?></a></p>
    <ul>
        <?php foreach ($siteMeta['nav_items'] as $item): ?>
            <li><a href="<?= htmlspecialchars($item['path'] ?? '#', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>