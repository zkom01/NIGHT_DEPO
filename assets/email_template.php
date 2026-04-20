<html lang="cs">
<body style="margin: 0; padding: 0; background-color: rgba(0, 0, 0, 0.2); font-family: Arial, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #1a222b; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width: 600px; background-color: rgba(0, 0, 0, 0.2); border: 2px solid #BDD9F2; border-radius: 10px; overflow: hidden;" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
                        <td style="padding: 20px; background-color: #8A038C; text-align: center;">
                            <h1 style="color: #BDD9F2; margin: 0; font-size: 24px; text-transform: uppercase;">Zpráva z night_depo</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px; color: #BDD9F2;">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                <tr>
                                    <td style="border-bottom: 1px solid #BDD9F2;">
                                        <strong style="color: #8A038C;">Odesílatel:</strong><br>
                                        <span style="font-size: 18px;" border-bo>{{name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #BDD9F2;">
                                        <strong style="color: #8A038C;">E-mail:</strong><br>
                                        <a href="mailto:{{email}}" style="color: #BDD9F2; text-decoration: none;">{{email}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 20px;">
                                        <strong style="color: #8A038C;">Text zprávy:</strong>
                                        <div style="margin-top: 10px; padding: 15px; background-color: rgba(0, 0, 0, 0.2); border: 1px solid #BDD9F2; border-radius: 6px; color: #BDD9F2; line-height: 1.5;">
                                            {{message}}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 15px; background-color: #1a222b; text-align: center; font-size: 12px; color: rgba(189, 217, 242, 0.5);">
                            Tato zpráva byla odeslána z kontaktního formuláře. &copy; {{year}} nightdepo.zkom.cz
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>