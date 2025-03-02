<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clerk</title>
</head>
<body>
    <h1>Clerk</h1>

    @if (auth()->check())
        <p>User ID: {{ auth()->id() }}</p>
        <p>Username: {{ auth()->user()->email }}</p>
    @endif

    <div id="app"></div>

    <script
    async
    crossorigin="anonymous"
    data-clerk-publishable-key="{{ env('CLERK_PUBLISHABLE_KEY') }}"
    src="https://warm-toucan-62.clerk.accounts.dev/npm/@clerk/clerk-js@5/dist/clerk.browser.js"
    type="text/javascript"
    ></script>
    <script>
        window.addEventListener('load', async function () {
            await Clerk.load()

            if (Clerk.user) {
            document.getElementById('app').innerHTML = `
                <div id="user-button"></div>
            `

            const userButtonDiv = document.getElementById('user-button')

            Clerk.mountUserButton(userButtonDiv)
            } else {
            document.getElementById('app').innerHTML = `
                <div id="sign-in"></div>
            `

            const signInDiv = document.getElementById('sign-in')

            Clerk.mountSignIn(signInDiv)
            }
        })
    </script>
</body>
</html>
