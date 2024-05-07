<script>
    import {useForm} from "@inertiajs/svelte";


    export let hoihoi = "Default Name";

    let chatPrompt = useForm({
        chat: "",
        history: []
    })


</script>

<!--<div class="border bg-gold w-full h-1/2">-->

<!--</div>-->

<!--<form on:submit|preventDefault={()=>{-->
<!--    $chatPrompt.history.push({role:"user", content:$chatPrompt.chat})-->
<!--    $chatPrompt.post('/ChatLLM')-->
<!--}}>-->
<!--<input class="border-2 text-black" type="text" id="prompt" bind:value={$chatPrompt.chat}>-->
<!--</form>-->

<div class="border bg-blue-300 w-1/4 h-screen overflow-auto">
    <div class="text-center">
        <p class="text-2xl">Chatgeschiedenis</p>
    </div>

    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        aaa
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>

    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        aaa
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
    aaa
</div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
    aaa
</div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
    aaa
</div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>    <div class="bg-yellow-100 m-4 text-xl rounded-md">
    aaa
</div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        bbb
    </div>
    <div class="bg-yellow-100 m-4 text-xl rounded-md">
        ccc
    </div>
</div>
