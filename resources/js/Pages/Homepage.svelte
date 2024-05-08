<script>
    import { useForm } from "@inertiajs/svelte";

    export let hoihoi = "Default Name";

    let chatPrompt = useForm({
        chat: "",
        history: []
    });

    function handleSubmit() {
        chatPrompt.history.push({ role: "user", content: chatPrompt.chat });
        chatPrompt.post('/ChatLLM');
    }
</script>

<div class="flex flex-col justify-between h-screen w-full">
    <!--    <div class="border bg-gold w-full h-1/2">-->
    <!--        {#each $chatPrompt.history as message}-->
    <!--            <div class="p-2">-->
    <!--                <strong>{message.role}: </strong>{message.content}-->
    <!--            </div>-->
    <!--        {/each}-->
    <!--    </div>-->

    <div class="absolute bottom-0 right-0 container mx-auto flex justify-end h" style="height: 20%">
        <form on:submit|preventDefault={handleSubmit} class="bg-gray-100 flex items-center border border-gray-300 p-2 w-3/4">
            <input
                class="bg-white border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2  ml-8"
                type="text"
                id="prompt"
                bind:value={chatPrompt.chat}
                style="width: 90%; height: 50%"
                placeholder="Typ uw bericht hier..."
            />
            <button
                type="submit"
                class="bg-blue-500 text-white text-sm rounded-full p-2 ml-4"
                style="width: 3.5rem; height: 3.5rem;"
            >
                ➤
            </button>
        </form>
    </div>
</div>
