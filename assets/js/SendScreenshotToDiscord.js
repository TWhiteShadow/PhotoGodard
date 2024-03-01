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
        formData.append('content', `:white_check_mark: Screenshot taken on: ${lastScreenDate}`);

        try {
            const response = await fetch(webhookUrl, {
                method: 'POST',
                body: formData
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
