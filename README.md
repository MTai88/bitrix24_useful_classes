### Bitrix24 useful classes

### 1. `MTai\Sender\SegmentService` - Create sender segment with your list of addresses in `/marketing/segment/`
- Example:
```
use MTai\Sender\SegmentService;


$segment = new SegmentService(0, 'My test segment'); // fisrt parameter is segment id, if 0 creates new
$data = [
    [
        'CODE' => "email1@test.com",
        'NAME' => "Anastasia Terry"
    ],
    [
        'CODE' => "email2@test.com",
        'NAME' => "Zuzanna Murphy"
    ]
];
$segment->upload($data);
```

### 2. `ChatService` - Class to work with Im chat module
- Example:
```
use MTai\Im\ChatService;

$chat = new ChatService;
$chat->add(
    "Test chat", // Chat title 
    1   // Author Id
);
$chat->addUser(1032);
$chat->addMessage(1, "Test message");
```

### 3. `MTai\Tools\UserContentViewHelper` - Helper to set & display users view counter to iblock element content
- Example:
```
use MTai\Tools\UserContentViewHelper;

$viewHelper = new UserContentViewHelper();

$iblockElementIds = [12, 14, 15, 23]; // Iblock elements ids
$ContentViewData = $this->viewHelper->getViewData($iblockElementIds); // array of viewed count


// Set view to element by current user
$elementId = 12;
$this->viewHelper->set($elementId);
```
- [Usage in components](https://github.com/MTai88/bitrix24_view_count)