# Steam profile card
### Fully responsive steam profile card with friends and games list

Has changing variables such as colors for profile status, has hover effects and checks to ensure certain data is available from the user.

### Setup:

Search this repository for `$api_key = '';` and put in your steam api key betweeen the ''

Create a cron job (every 5, 10 or 15 so minutes) and point it at 

`get_profile.php?steamid=X`

`get_friends.php?steamid=X`
 
`get_games.php?steamid=X`
   
 with `X` being the steam profile you wanna get data for.
   
 These 3 calls create .json files with formatted data which is what we use on the profile cards. Now you can go to `index.php?steamid=X` and youre good to go, your profile cards is made.
 
 Technologies used:
 
 * PHP
 * HTML & CSS
 * Steam API

Images:

![Alt Text](https://i.imgur.com/xItJj84.png)
![Alt Text](https://i.imgur.com/mRwcaWv.png)
![Alt Text](https://i.imgur.com/azMHWq9.png)
