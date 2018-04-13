# Use guide

```
use Betterde\Tree\Generator;

public function index()
{
    $generator = new Generator();
    
    $tree = $generator->make($collection, 'code', 'parent_code', 'children', '');
} 

```