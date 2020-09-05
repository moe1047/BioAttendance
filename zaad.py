# Online Python compiler (interpreter) to run Python online.
# Write Python 3 code in this online editor and run it.
from datetime import date
today = date.today()
import requests

sessionID = ""
requestID = "239923"
merchantID = 'M0910002'
apiUserID = '1000010'
apikey = 'APIXTOIWEHSDLKOSEKYR'
url = "https://sandbox.safarifoneict.com/asm"
payload = {"schemaVersion" : "1.0",
                "requestId"     : "12345",
                "timestamp"     : today.strftime("%Y-%m-%d H:i:s"),
                "channelName"   : "WEB",
                "serviceName"   : "API_PURCHASE",
                "serviceParams" : {
                    "merchantUid" : merchantID,
                    "apiUserId" : apiUserID,
                    "apiKey": apikey,
                    "paymentMethod" : "MWALLET_ACCOUNT",

                    "payerInfo" : {
                        "accountNo" : '252634711110',
                    },

                    "transactionInfo" : {
                        "referenceId"   : "R3489743",
                        "invoiceId"     : "INV100012",
                        "amount"        : 0.01,
                        "currency"      : "USD",
                        "description"   : "test1 transaction"
                    }
                    }}
res = requests.post(url, data=payload)
print(res.text)
