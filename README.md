# steam-profile-card
Steam profile card with friends and games list

Create a cron job (every 5, 10 or 15 so minutes) and point it at 

`get_profile.php?steamid=X`

`get_friends.php?steamid=X`
 
`get_games.php?steamid=X`
   
 with `X` being the steam profile you wanna get data for.
   
 These 3 calls create json files with formatted data which is what we use on the profile cards. Now you can go to `index.php?steamid=X` and youre good to go your profile cards is made.


Images: 

![Alt Text](https://imgur.com/a/7EXWD)
![Alt Text](https://imgur.com/a/EjJWq)
![Alt Text](https://imgur.com/a/7yEzN)
