using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace SimplePlatformer
{
    public partial class Form1 : Form
    {
        bool goLeft = false;
        bool goRight = false;
        bool jumping = false;
        bool hasKey = false;

        int jumpSpeed = 10;
        int force = 8;
        int score = 0;

        int playSpeed = 18;
        int backgroundPositionLeft = 8;


        public Form1()
        {
            InitializeComponent();
        }
        
        private void mainGameTimer(object sender, EventArgs e)
        {
            //linking jumpspeed w/ playerPictureBox to location - making false gravity
            //player will be pushed back down the same length as jumped up
            player.Top += jumpSpeed;

            //keep refreshing player - reducing flickering when moving
            player.Refresh();

            //show score
            scoreBox.Text = "Score: " + score;

            if (jumping && force < 0)
            {
                jumping = false;
            }

            //reverse jumpspeed to propel player upwards - else will trigger after this is false
            if (jumping)
            {
                jumpSpeed = -12;
                force -= 1;
            }
            else
            {
                jumpSpeed = 12;
            }

            //check that player is more than 100px from the left edge
            //avoid player being able to "leave" the form
            if (goLeft && player.Left > 100)
            {
                player.Left -= playSpeed;
            }

            //check if there is space to move right
            if (goRight && player.Left + (player.Width + 100) < this.ClientSize.Width)
            {
                player.Left += playSpeed;
            }

            //move background to the left player if moving to the right, same amount of steps
            if (goRight && background.Left > -1353)
            {
                background.Left -= backgroundPositionLeft;

                //Loops around searching for platforms & coins etc - when found moved bkg to the left
                foreach (Control x in this.Controls)
                {
                    if (x is PictureBox && x.Tag == "platform" || x is PictureBox && x.Tag == "coin"
                                                               || x is PictureBox && x.Tag == "door"
                                                               || x is PictureBox && x.Tag == "key")
                    {
                        x.Left -= backgroundPositionLeft;
                    }
                }
            }

            //if player is going left + background left position is less than 2, move bkg to the left
            if (goLeft && background.Left < 2)
            {
                background.Left += backgroundPositionLeft;

                foreach (Control x in this.Controls)
                {
                    if (x is PictureBox && x.Tag == "platform" || x is PictureBox && x.Tag == "coin"
                                                               || x is PictureBox && x.Tag == "door"
                                                               || x is PictureBox && x.Tag == "key")
                    {
                        x.Left += backgroundPositionLeft;
                    }
                }
            }

            foreach (Control x in this.Controls)
            {
                if (x is PictureBox && x.Tag == "platform")
                {
                    //check if player is colliding w/platform
                    if (player.Bounds.IntersectsWith(x.Bounds) && !jumping)
                    {
                        force = 8;
                        player.Top = x.Top - player.Height; //place player on top of pictureBox
                        jumpSpeed = 0;
                    }
                }

                //is pictureBox a coin?
                if (x is PictureBox && x.Tag == "coin")
                {
                    //if so, check if colliding - and if SO - remove coin from board
                    // & add a scorepoint
                    if (player.Bounds.IntersectsWith(x.Bounds))
                    {
                        this.Controls.Remove(x);
                        score++;
                    }
                }

            }


            //colliding with door? Do they have the key?
            if (player.Bounds.IntersectsWith(door.Bounds) && hasKey)
            {
                //change door img to opendoor
                door.Image = Properties.Resources.door_open;
                //stop timer - level completed
                gameTimer.Stop();
                MessageBox.Show("You completed the level! Congrats!");
            }

            //colliding with key?
            if (player.Bounds.IntersectsWith(key.Bounds))
            {
                //remove key img, and player now has key
                this.Controls.Remove(key);
                hasKey = true;
            }

            //check if player dies (falls down)
            if (player.Top + player.Height > this.ClientSize.Height + 60)
            {
                gameTimer.Stop();
                MessageBox.Show("You Died! Better Luck next time!");
            }
        }


        private void keyisdown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Left)
            {
                goLeft = true;
            }

            if (e.KeyCode == Keys.Right)
            {
                goRight = true;
            }

            if (e.KeyCode == Keys.Space && !jumping)
            {
                jumping = true;
            }
        }

        private void keyisup(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Left)
            {
                goLeft = false;
            }

            if (e.KeyCode == Keys.Right)
            {
                goRight = false;
            }

            if (jumping)
            {
                jumping = false;
            }

        }
    }
 }


