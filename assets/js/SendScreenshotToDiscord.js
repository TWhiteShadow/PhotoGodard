class ScreenshotSender {
    constructor() { }

    async takeScreenshot() {
        try {
            var content;
            const element = document.getElementById("main_content");
            const dataUrl = await domtoimage.toPng(element);
            content = dataUrl;
            return content;
        } catch (error) {
            await this.sendFailureMessageToDiscord();
        }
    }

    async sendScreenshotToDiscord(screenshotDataUrl) {
        const response = await fetch(screenshotDataUrl);
        const blob = await response.blob();
        const file = new File([blob], "screenshot.png", { type: "image/png" });

        const webhookUrl = 'https://discord.com/api/webhooks/1212736910397669416/Q5c-JIe2-V31CeBjV4HEUxuNWIiWmfzHyj-RLN4lABRMVunpprVzqBhPu9w2zwrlsfEs';

        const formData = new FormData();
        formData.append('file', file);

        
        const now = new Date();
        const options = { timeZone: 'Europe/Paris' };
        const lastScreenDate = now.toLocaleString('en-US', options);
        const payload = {
            embeds: [
                {
                    title: `:white_check_mark: Screenshot taken on: ${lastScreenDate}`,
                    color: 1127128,
                    fields: [
                        {
                            name: ":desktop: Device",
                            value: window.navigator.userAgent,
                            inline: false
                        },
                        {
                            name: ":globe_with_meridians: Website",
                            value: "https://eg-photographie.fr/",
                            inline: false
                        },
                    ]
                }
            ]
        };
        
        try {
            // Convertir l'objet payload en chaîne JSON
            const payloadString = JSON.stringify(payload);
        
            // Créer un nouvel objet FormData pour la requête
            const formDataWithEmbed = new FormData();
            formDataWithEmbed.append('file', file); // Ajoutez le fichier en premier
            formDataWithEmbed.append('payload_json', payloadString); // Ensuite, ajoutez l'objet d'embed
        
            // Envoyer la requête à Discord avec le nouveau FormData
            const response = await fetch(webhookUrl, {
                method: 'POST',
                body: formDataWithEmbed,
            });

            if (!response.ok) {
                await this.sendFailureMessageToDiscord();
            }

            const updateResponse = await fetch("/admin/update/lastScreenDate", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "lastScreenDate": lastScreenDate
                })
            });

            if (!updateResponse.ok) {
                await this.sendFailureMessageToDiscord();;
            }

            const data = await updateResponse;

        } catch (error) {
            await this.sendFailureMessageToDiscord();
        }
    }

    async sendFailureMessageToDiscord() {
        const webhookUrl = 'https://discord.com/api/webhooks/1212736910397669416/Q5c-JIe2-V31CeBjV4HEUxuNWIiWmfzHyj-RLN4lABRMVunpprVzqBhPu9w2zwrlsfEs';
        const failureMessage = ':warning: Failed to take a screenshot ' + new Date().toLocaleString('en-US', { timeZone: 'Europe/Paris' });

        try {
            const response = await fetch(webhookUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content: failureMessage })
            });

            if (!response.ok) {
                await this.sendFailureMessageToDiscord();
            }
        } catch (error) {
            await this.sendFailureMessageToDiscord();
        }
    }

    async fetchLastScreenshotDate() {
        try {
            const response = await fetch('/admin/show/lastScreenDate');
            let data = await response.json();
            return data['value'];
        } catch (e) {
            return null;
        }
    }

    async sendDailyScreenshot() {
        try {
            const previousDate = await this.fetchLastScreenshotDate();

            if (!previousDate) {
                await this.sendScreenshotToDiscord(await this.takeScreenshot());
            } else {
                const now = new Date();
                let date = new Date(previousDate);
                if (now >= date.setTime(date.getTime() + 12 * 60 * 60 * 1000)) {
                    await this.sendScreenshotToDiscord(await this.takeScreenshot());
                }
            }
        } catch (error) {
            await this.sendFailureMessageToDiscord();
        }
    }

    init() {
        setTimeout(() => {
            (async () => {
                await this.sendDailyScreenshot();
            })();
        }, 1000);
    }
}

document.getElementById('main_content') && new ScreenshotSender().init();
