import requests
import time


# Step 1: Get authentication token
token_url = 'https://[yourfirmURL]/ms/caseware-cloud/api/v1/auth/token'
auth_data = {
  "ClientId": "[YourClientID]",
  "ClientSecret": "[YourClientSecret]",
  "Language": "en"
}
token_response = requests.post(token_url, json=auth_data)

if token_response.status_code != 200:
    # Handle error if the status code is not 200 (OK)
    error_message = token_response.json().get('errorMessage', 'Unknown error')
    print(f"Token request error: {error_message}")
    exit(1)

token = token_response.json().get('Token')  # Extract the token value from the response

# Step 2: Get Engagement Data using the token
# For example, query metadata
metadata_url = 'https://[yourfirmURL]/ms/sherlock/api/v1/query/view/metadata'
# Modify the query parameter "q" to filter the metadata if needed.
# For example, if you want to filter by yearend, you can use something like: "?q=yearend=2020"
query_param = "?q=yearend=2020"
headers = {'Authorization': f'Bearer {token}'}
metadata_response = requests.get(metadata_url + query_param, headers=headers)


if metadata_response.status_code != 200:
    # Handle error if the status code is not 200 (OK)
    error_message = metadata_response.json().get('errorMessage', 'Unknown error')
    print(f"Metadata request error: {error_message}")
    exit(1)

metadata = metadata_response.json()



# Step 3: Check if status is SUCCEEDED and import data to Power BI
if metadata.get('status') == 'SUCCEEDED':
    file_url = metadata.get('fileUrl')
    file_response = requests.get(file_url)
    # Save the downloaded file
    with open('data.csv', 'wb') as f:
        f.write(file_response.content)
  

# Step 4: Handle the case when status is "running"
elif metadata.get('status') == 'RUNNING':
    job_id = metadata.get('jobId')
    status_url = f'https://[yourfirmURL]/ms/sherlock/api/v1/status/{job_id}'
    while True:
        status_response = requests.get(status_url, headers=headers)
        status = status_response.json().get('status')
        if status == 'SUCCEEDED':
            file_url = status_response.json().get('fileUrl')
            file_response = requests.get(file_url)
            # Save the downloaded file
            with open('data.csv', 'wb') as f:
                f.write(file_response.content)
          
            break
        elif status == 'FAILED':
            error_message = status_response.json().get('errorMsg')
            error_detail = status_response.json().get('errorDetail')
            print(f"Error: {error_message}")
            print(f"Error detail: {error_detail}")
            break
        else:
            # Wait for a certain interval before checking status again
            time.sleep(1000)