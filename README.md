# use-chatwork-api-for-php
PHP Class for Using ChatworkAPI.

# Usage
It is easy to use for everybody as like this.

```php:like this.
include('Chatwork.php');	// Include module.

$ch = new Chatwork('your apitoken');	// Initialize with your api token.
$roomid = $ch->getRoomID('room name');	// Get specific roomID indentified by roomName.
$ch->sendMessage($roomid, "Put any messages.");	// Send any messages by accuired roomID.
```

