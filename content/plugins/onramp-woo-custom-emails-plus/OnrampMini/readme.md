### How to build plugin main php
```
php bin/build.php
```

### How to start edit code
```
vi App/ServiceProvider.php
```

### How to copy project and replace namespace
```
目前 OnrampMini 是測試性質, 所以沒有獨立出最底層的 namespace
如果想要建立新的 plugin
可以將專案複製過去後, 用指令修改 namespace

FROM="OriginNamespace"
TOTO="NewNamespace"

ack $FROM
find ./ -type f -print0 | xargs -0 sed -i -e "s/$FROM/$TOTO/g"




```