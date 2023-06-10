<div>
    <div x-data="{ open: false }">
        <button @click="open = true">Show More...</button>
 
        <ul x-show="open" @click.outside="open = false">
            <li><button wire:click="archive">Archive</button></li>
            <li><button wire:click="delete">{{$limit}}</button></li>
        </ul>
    </div>

</div>
