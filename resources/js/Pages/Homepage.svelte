<script>
    import {useForm} from "@inertiajs/svelte";


    export let hoihoi = "Default Name";

    let chatPrompt = useForm({
        chat: "",
        history: []
    })

</script>

<div class="border bg-gold w-full h-1/2">

</div>

<form on:submit|preventDefault={()=>{
    $chatPrompt.history.push({role:"user", content:$chatPrompt.chat})
    $chatPrompt.post('/ChatLLM')
}}>
<input class="border-2 text-black" type="text" id="prompt" bind:value={$chatPrompt.chat}>
</form>
