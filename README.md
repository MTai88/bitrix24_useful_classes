### Bitrix24 useful classes

### 1. `SegmentService` - Create sender segment with your list of addresses in `/marketing/segment/`
- Class directory - `/sender/`
- Example:
```
use Mymodule\Sender\SegmentService;


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

 