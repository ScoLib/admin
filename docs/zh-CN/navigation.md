# 导航

## Title

## Icon 

## PageId

## ParentPageId

## Priorty




string|null getPageId()
Get the page id

$this setPageId(string $pageId)
Set the page id

string|null getIcon()
Get the page icon class name.

$this setIcon(string $icon)
Set the page icon class name.

string getParentPageId()
No description

$this setParentPageId(string $parentPageId)
No description

hasParentPageId()
No description

int getPriority()
No description

$this setPriority(int $priority)
No description

getNavigation()
{@inheritdoc}

addToNavigation($badge = null)
{@inheritdoc}

Page makePage(string|Closure|null $badge = null)
Make page

string getDisplayUrl(array $parameters = [])
Get the model display url.